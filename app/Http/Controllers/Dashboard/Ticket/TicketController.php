<?php

namespace App\Http\Controllers\Dashboard\Ticket;

use App\Helpers\TicketNumberHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\TicketCreateRequest;
use App\Models\Attachment;
use App\Models\Comment;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class TicketController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user_role = $user->role;

        if (\request()->ajax()){
            $data_builder = Ticket::getTicketByRole(role: $user_role, user_id: $user->id);
            $engineers = User::query()->where("role", "=", "engineer")->get();

            foreach ($data_builder as $ticket) {
                $ticket->label = implode(', ', array_map('ucwords', $ticket->label));
                $ticket->category = implode(', ', array_map('ucwords', $ticket->category));
                $ticket->priority = ucfirst($ticket->priority);
                $ticket->status = ucfirst($ticket->status);
                $ticket->engineer_id = is_null($ticket->engineer_id) ? "Not assigned" : $engineers->where("id", "=", $ticket->engineer_id)->first()->name ?? "Unknown Engineer";
            }

            return DataTables::of($data_builder)
                ->addColumn('action', function ($row) use ($engineers) {
                    return view("components.assign-engineer-to-ticket",
                        [
                            "id" => $row->id,
                            "engineers" => $engineers,
                            "status" => $row->status,
                            "notification" => Comment::getNotification($row->id)
                        ]);
                })
                ->toJson();
        }

        return view("dashboard.tickets.ticket", [
            "title_page" => "Support Ticket System | Tickets"
        ]);
    }

    public function create()
    {
        $this->authorize("createNewTicket", Ticket::class);

        return view("dashboard.tickets.form.form-ticket", [
            "title_page" => "Support Ticket System | Create Ticket"
        ]);
    }

    public function store(TicketCreateRequest $request)
    {
        $this->authorize("createNewTicket", Ticket::class);

        try {
            DB::beginTransaction();

            $currentUser = Auth::user();

            // Generate Ticket Number
            $ticketNumber = TicketNumberHelper::generateTicketNumber();

            $validated = $request->validated();

            $ticket = Ticket::query()->create([
                "ticket_number" => $ticketNumber,
                "title" => $validated['title'],
                "description" => $validated['description'],
                "label" => $validated['labels'],
                "category" => $validated['categories'],
                "priority" => $validated['priority'],
                "user_id" => $currentUser->id
            ]);

            $ticketId = $ticket->id;

            if ($request->hasFile("attachments")) {
                $attachments = $request->file("attachments");

                foreach ($attachments as $attachmentFile) {
                    // Generate nama unik untuk file
                    $fileName = uniqid('attachment_') . '.' . $attachmentFile->getClientOriginalExtension();

                    // Simpan file ke direktori yang diinginkan
                    $filePath = $attachmentFile->storeAs('public/attachments/user_id_' . auth()->id(), $fileName);

                    // Simpan informasi file ke dalam database
                    $attachment = new Attachment();
                    $attachment->ticket_id = $ticketId;
                    $attachment->file_name = $fileName;
                    $attachment->file_path = $filePath;
                    $attachment->save();
                }
            }

            \App\Models\Log::query()->create([
               "ticket_id" => $ticketId,
               "user_id" => $currentUser->id,
               "type" => "CREATE",
               "activity" => "Pengguna telah membuat ticket baru"
            ]);

            DB::commit();
            return redirect()->route("ticket.index")->with('success_create_ticket', 'Ticket berhasil dibuat!');
        } catch(\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return redirect()->route("ticket.index")->with('error_create_ticket', 'Terjadi kesalahan saat membuat ticket!');
        }
    }

    public function assignEngineer(Request $request)
    {
        $this->authorize("assignEngineerToTicket", Ticket::class);

        try {
            DB::beginTransaction();

            $currentUser = Auth::user();

            $ticketId = $request->input('ticket_id');
            $engineerId = $request->input('engineer_id');

            // Menggunakan "SELECT ... FOR UPDATE" untuk mengunci baris
            $ticket = Ticket::query()->where("id", "=", $ticketId)->lockForUpdate()->firstOrFail();

            // Melakukan pembaruan data tiket
            $ticket->engineer_id = $engineerId;
            $ticket->status = "ongoing";
            $ticket->save();

            \App\Models\Log::query()->create([
                "ticket_id" => $ticketId,
                "user_id" => $currentUser->id,
                "type" => "ASSIGN",
                "activity" => "Admin telah menetapkan " . User::query()->where("id", "=", $engineerId)->value("name") . " , sebagai engineer untuk ticket ini"
            ]);

            DB::commit();
            return redirect()->route("ticket.index")->with('success_assign_ticket', 'Berhasil menetapkan engineer!');
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return redirect()->route("ticket.index")->with('error_assign_ticket', 'Gagal menetapkan engineer!');
        }
    }

    public function closeTicket(Request $request)
    {
        try {
            DB::beginTransaction();

            $currentUser = Auth::user();

            $ticketId = $request->input('ticket_id');

            $ticket = Ticket::findOrFail($ticketId);
            $ticket->status = "closed";
            $ticket->save();

            \App\Models\Log::query()->create([
                "ticket_id" => $ticketId,
                "user_id" => $currentUser->id,
                "type" => "CLOSED",
                "activity" => "Pengguna telah menutup ticket ini"
            ]);

            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
