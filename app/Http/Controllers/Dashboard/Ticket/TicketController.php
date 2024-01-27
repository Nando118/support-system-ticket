<?php

namespace App\Http\Controllers\Dashboard\Ticket;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TicketController extends Controller
{
    public function index()
    {
        if (\request()->ajax()){
            $data_builder = Ticket::query()->get();
            return DataTables::of($data_builder)
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group mr-1">';
                    $btn .= '<a href="#" class="btn btn-warning btn-sm" title="Edit"><i class="fas fa-fw fa-edit"></i></a> ';
                    $btn .= '<button type="button" class="delete btn btn-danger btn-sm" title="Delete" data-url="#"><i class="fas fa-fw fa-trash"></i></button> ';
                    $btn .= '</div>';
                    return $btn;
                })
                ->toJson();
        }

        return view("dashboard.tickets.ticket", [
            "title_page" => "Support Ticket System | Tickets"
        ]);
    }

    public function create(){
        return view("dashboard.tickets.form.form-ticket", [
            "title_page" => "Support Ticket System | Create Ticket"
        ]);
    }
}
