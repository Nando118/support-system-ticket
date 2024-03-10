@extends('dashboard.layouts.main-layouts')

@section('content_header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route("home.index") }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route("ticket.index") }}">Tickets</a></li>
            <li class="breadcrumb-item"><a href="{{ route("ticket.comments.index", ["id" => $ticket->id]) }}">Comments</a></li>
            <li class="breadcrumb-item active" aria-current="page">Reply</li>
        </ol>
    </nav>

@endsection

@section('content')
    <div class="container pt-2 pb-3">
        <div class="card">
            <div class="card-header font-weight-bold">
                Comment
            </div>
            <div class="card-body">
                <form id="form_reply_ticket" action="{{ route("ticket.comments.store", ["id" => $ticket->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="ticket_id" name="ticket_id" value="{{ $ticket->id }}">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Description<span style="color: red;">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="exampleFormControlTextarea1" rows="5" name="description" placeholder="Describe your problem here..." style="resize: none;">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="validatedCustomFile">Attachments</label>
                        <div class="custom-file mb-3">
                            <input type="file" class="custom-file-input @error('attachments.*') is-invalid @enderror" id="customFile" name="attachments[]" multiple accept=".jpg, .jpeg, .png, .zip, .rar">
                            <label class="custom-file-label" for="customFile">Choose file...</label>
                            <small id="customFile" class="form-text text-muted">File max 2MB for Image, Video, ZIP, RAR.</small>
                            @error('attachments.*')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <button id="reply_ticket" class="btn btn-success" type="submit">Reply</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push("scripts")
    <script>
        // Disabled Button Submit Jika Sudah klik Submit
        $(document).ready(function () {
            $("#form_reply_ticket").submit(function (e) {
                // Menonaktifkan tombol submit
                $("#reply_ticket").prop("disabled", true);

                // Melakukan pengiriman form secara manual
                // Anda bisa menggunakan AJAX atau langsung submit form
                // Di sini saya menggunakan submit() untuk mengirim form secara langsung
                this.submit();
            });
        });

        // WYSIWYG - Tinymce
        tinymce.init({
            selector: 'textarea',
            menubar: false,
            plugins: 'lists',
            toolbar: 'bold italic underline | bullist numlist',
            placeholder: 'Reply to your ticket comments here...'
        });

    </script>
@endpush
