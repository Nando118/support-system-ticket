@extends('dashboard.layouts.main-layouts')

@section('content_header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route("home.index") }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route("ticket.index") }}">Tickets</a></li>
            <li class="breadcrumb-item active" aria-current="page">Comments</li>
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
            <div class="card-body" style="max-height: 40rem; overflow-y: auto;">
                <div class="alert alert-secondary" role="alert">
                    <div class="row">
                        <div class="col-6 text-left">
                            <p class="alert-heading"><i class="fa-solid fa-user"></i> {{ $ticket->user->name }}</p>
                        </div>
                        <div class="col-6 text-right">
                            <i class="fa-regular fa-clock"></i> {{ $ticket->created_at }}
                        </div>
                    </div>
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

                @foreach($comments as $index => $comment)
                    @if($index % 2 === 0)
                        <div class="alert alert-primary" role="alert">
                            <div class="row">
                                <div class="col-6 text-left">
                                    <p class="alert-heading"><i class="fa-solid fa-user"></i> {{ $comment->user->name }}</p>
                                </div>
                                <div class="col-6 text-right">
                                    <i class="fa-regular fa-clock"></i> {{ $comment->created_at }}
                                </div>
                            </div>
                            <p class="my-3">
                                {!! $comment->comment !!}
                            </p>
                            @if($comment->attachments->isNotEmpty())
                                <p class="h6 mt-5">Attachments</p>
                                <hr>
                                @foreach($comment->attachments as $attachment)
                                    <a href="{{ asset('storage/' . str_replace('public/', '', $attachment->file_path)) }}" class="badge badge-success" target="_blank">{{ $attachment->file_name }}</a>
                                @endforeach
                            @endif
                        </div>
                    @else
                        <div class="alert alert-secondary" role="alert">
                            <div class="row">
                                <div class="col-6 text-left">
                                    <p class="alert-heading"><i class="fa-solid fa-user"></i> {{ $comment->user->name }}</p>
                                </div>
                                <div class="col-6 text-right">
                                    <i class="fa-regular fa-clock"></i> {{ $comment->created_at }}
                                </div>
                            </div>
                            <p class="my-3">
                                {!! $comment->comment !!}
                            </p>
                            @if($comment->attachments->isNotEmpty())
                                <p class="h6 mt-5">Attachments</p>
                                <hr>
                                @foreach($comment->attachments as $attachment)
                                    <a href="{{ asset('storage/' . str_replace('public/', '', $attachment->file_path)) }}" class="badge badge-success" target="_blank">{{ $attachment->file_name }}</a>
                                @endforeach
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-12 text-left">
                        <a href="{{ route("ticket.comments.create", ["id" => $ticket->id]) }}" class="btn btn btn-primary btn-sm" role="button" ><i class="fas fa-reply"></i> Reply Ticket</a>
                        <button type="button" class="btn btn-success btn-sm" title="Close Ticket"><i class="fa-solid fa-check"></i> Close Ticket</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push("scripts")
    <script>
        // POP UP Message
        @if(session('success_reply_ticket'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil membalas ticket!',
                text: '{{ session('success_reply_ticket') }}'
            });
        @endif
        @if(session('error_reply_ticket'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal membalas ticket!',
                text: '{{ session('error_reply_ticket') }}'
            });
        @endif
    </script>
@endpush
