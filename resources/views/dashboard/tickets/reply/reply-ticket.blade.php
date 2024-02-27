@extends('dashboard.layouts.main-layouts')

@section('content_header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route("home.index") }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route("ticket.index") }}">Tickets</a></li>
            <li class="breadcrumb-item active" aria-current="page">Reply</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                <div class="row">
                    <div class="col-6 text-left">
                        Ticket No. {{ $ticket->ticket_number }}
                    </div>
                    <div class="col-6 text-right">
                        @foreach($ticket->label as $label)
                            <span class="badge badge-info">{{ ucfirst($label) }}</span>
                        @endforeach

                        @foreach($ticket->category as $category)
                            <span class="badge badge-success">{{ ucfirst($category) }}</span>
                        @endforeach

                        @if($ticket->priority == "high")
                            <span class="badge badge-warning">High</span>
                        @elseif($ticket->priority == "low")
                            <span class="badge badge-secondary">Low</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-secondary" role="alert">
                    <p class="alert-heading"><i class="fa-solid fa-user"></i> {{ $ticket->user->name }}</p>
                    <h4 class="alert-heading">{{ $ticket->title }}</h4>
                    <p class="my-3">
                        {!! $ticket->description !!}
                    </p>
                    @if($attachments->isNotEmpty())
                        <p class="h6 mt-5">Attachments</p>
                        <hr>
                        @foreach($attachments as $attachment)
                            <a href="{{ asset('storage/' . str_replace('public/', '', $attachment->file_path)) }}" class="badge badge-success" target="_blank">{{ $attachment->file_name }}</a>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="card-footer">
                <i class="fa-regular fa-clock"></i> {{ $ticket->created_at }}
            </div>
        </div>
    </div>
@endsection
