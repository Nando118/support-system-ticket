<?php

namespace App\Http\Controllers\Dashboard\Log;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class LogController extends Controller
{
    public function index()
    {
        $this->authorize("viewLogs", Log::class);

        if (\request()->ajax()){
            $data_builder = Log::query()->get();

            foreach ($data_builder as $log) {
                $log->ticket_id = $log->ticket->ticket_number;
                $log->user_id = $log->user->email;
            }

            return DataTables::of($data_builder)->toJson();
        }

        return view("dashboard.logs.log", [
            "title_page" => "Support Ticket System | Ticket Logs"
        ]);
    }
}
