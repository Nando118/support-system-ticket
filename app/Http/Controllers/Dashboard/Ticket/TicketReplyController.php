<?php

namespace App\Http\Controllers\Dashboard\Ticket;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketReplyController extends Controller
{
    public function index(string $id) {

        $ticket = Ticket::query()->where("id", "=", $id)->firstOrFail();

        $this->authorize("view", $ticket);

        $attachments = Attachment::query()->where("ticket_id", "=", $ticket->id)->get();

        return view("dashboard.tickets.reply.reply-ticket", [
            "title_page" => "Support Ticket System | Reply Ticket",
            "ticket" => $ticket,
            "attachments" => $attachments
        ]);
    }
}
