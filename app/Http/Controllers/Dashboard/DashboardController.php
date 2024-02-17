<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user_role = $user->role;
        $total_tickets = Ticket::getTicketByRole($user_role, $user->id)->count();
        $pending_tickets = Ticket::getCountTicketByRoleStatus($user_role, $user->id, "pending");
        $ongoing_tickets = Ticket::getCountTicketByRoleStatus($user_role, $user->id, "ongoing");
        $closed_tickets = Ticket::getCountTicketByRoleStatus($user_role, $user->id, "closed");

         return view("dashboard.main-dashboard", [
             "title_page" => "Support Ticket System | Dashboard",
             "total_tickets" => $total_tickets,
             "pending_tickets" => $pending_tickets,
             "ongoing_tickets" => $ongoing_tickets,
             "closed_tickets" => $closed_tickets
        ]);
    }
}
