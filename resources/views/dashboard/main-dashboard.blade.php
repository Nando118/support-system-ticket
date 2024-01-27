@extends('dashboard.layouts.main-layouts')

@section('content_header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Home</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header font-weight-bold">
                Dashboard
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <div class="card">
                            <div class="card-footer alert alert-success text-center">
                                <i class="fa-solid fa-ticket fa-xl"></i>
                                <span class="font-weight-bold ml-2">Total Tickets</span>
                            </div>
                            <div class="card-body text-center">
                                <p class="card-text font-weight-bolder">99999</p>
                                <a href="{{ route("ticket.index") }}" class="btn btn-primary">Check</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="card">
                            <div class="card-footer alert alert-danger text-center">
                                <i class="fa-solid fa-ticket fa-xl"></i>
                                <span class="font-weight-bold ml-2">Pending Tickets</span>
                            </div>
                            <div class="card-body text-center">
                                <p class="card-text font-weight-bolder">99999</p>
                                <a href="{{ route("ticket.index") }}" class="btn btn-primary">Check</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="card">
                            <div class="card-footer alert alert-secondary text-center">
                                <i class="fa-solid fa-ticket fa-xl"></i>
                                <span class="font-weight-bold ml-2">Closed Tickets</span>
                            </div>
                            <div class="card-body text-center">
                                <p class="card-text font-weight-bolder">99999</p>
                                <a href="{{ route("ticket.index") }}" class="btn btn-primary">Check</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
