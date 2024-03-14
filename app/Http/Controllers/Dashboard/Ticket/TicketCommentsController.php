<?php

namespace App\Http\Controllers\Dashboard\Ticket;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\TicketCommentRequest;
use App\Models\Attachment;
use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TicketCommentsController extends Controller
{
    public function index(string $ticket_id) {

        $ticket = Ticket::query()->where("id", "=", $ticket_id)->firstOrFail();
        $comments = Comment::query()->where("ticket_id", "=", $ticket_id)
            ->orderBy('created_at', 'asc')
            ->get();

        $this->authorize("view", $ticket);

        $attachments = Attachment::query()->where("ticket_id", "=", $ticket->id)
            ->whereNull("comment_id")
            ->get();

        return view("dashboard.tickets.comments.comments-ticket", [
            "title_page" => "Support Ticket System | Comments Ticket",
            "ticket" => $ticket,
            "comments" => $comments,
            "attachments" => $attachments
        ]);
    }

    public function create(string $ticket_id) {

        $ticket = Ticket::query()->where("id", "=", $ticket_id)->firstOrFail();

        $this->authorize('reply', $ticket);

        return view("dashboard.tickets.comments.form.form-comment-ticket", [
            "title_page" => "Support Ticket System | Reply Ticket",
            "ticket" => $ticket,
        ]);
    }

    public function store(TicketCommentRequest $request) {
        try {
            DB::beginTransaction();

            $validated = $request->validated();

            $ticket = Ticket::query()->where("id", "=", $validated["ticket_id"])->firstOrFail();
            $this->authorize('reply', $ticket);

            $comment = Comment::query()->create([
                "ticket_id" => $validated["ticket_id"],
                "user_id" => auth()->id(),
                "comment" => $validated["description"]
            ]);

            $commentId = $comment->id;

            if ($request->hasFile("attachments")) {
                $attachments = $request->file("attachments");

                foreach ($attachments as $attachmentFile) {
                    // Generate nama unik untuk file
                    $fileName = uniqid('attachment_') . '.' . $attachmentFile->getClientOriginalExtension();

                    // Simpan file ke direktori yang diinginkan
                    $filePath = $attachmentFile->storeAs('public/attachments/user_id_' . auth()->id(), $fileName);

                    // Simpan informasi file ke dalam database
                    $attachment = new Attachment();
                    $attachment->ticket_id = $validated["ticket_id"];
                    $attachment->comment_id = $commentId;
                    $attachment->file_name = $fileName;
                    $attachment->file_path = $filePath;
                    $attachment->save();
                }
            }

            DB::commit();
            return redirect()->route("ticket.comments.index", ["id" => $request->ticket_id])->with('success_reply_ticket', 'Ticket berhasil dibalas!');
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return redirect()->route("ticket.comments.index", ["id" => $request->ticket_id])->with('error_reply_ticket', 'Ticket gagal dibalas!');
        }
    }

    public function closeTicket(Request $request) {
        try {
            DB::beginTransaction();

            $ticketId = $request->input('ticket_id');

            $ticket = Ticket::findOrFail($ticketId);
            $ticket->status = "closed";
            $ticket->save();

            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
