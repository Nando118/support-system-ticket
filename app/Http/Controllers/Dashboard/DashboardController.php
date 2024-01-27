<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
         return view("dashboard.main-dashboard", [
            "title_page" => "Support Ticket System | Dashboard"
        ]);
    }
}
