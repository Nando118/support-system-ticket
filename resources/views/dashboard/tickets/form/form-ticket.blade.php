@extends('dashboard.layouts.main-layouts')

@section('content_header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route("home.index") }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route("ticket.index") }}">Tickets</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Ticket</li>
        </ol>
    </nav>

@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header font-weight-bold">
                Tickets
            </div>
            <div class="card-body">
                <form action="#" method="POST">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Title</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Enter title ticket here...">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Description</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder="Describe your problem here..."></textarea>
                    </div>
                    <div class="form-group">
                        <label for="checkbox">Labels</label> <br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input checkbox-lables-tickets" type="checkbox" id="inlineCheckbox1" value="bug">
                            <label class="form-check-label" for="inlineCheckbox1">Bug</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input checkbox-lables-tickets" type="checkbox" id="inlineCheckbox2" value="question">
                            <label class="form-check-label" for="inlineCheckbox2">Question</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input checkbox-lables-tickets" type="checkbox" id="inlineCheckbox3" value="enhancement">
                            <label class="form-check-label" for="inlineCheckbox3">Enhancement</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="checkbox">Categories</label> <br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input checkbox-categories-tickets" type="checkbox" id="inlineCheckbox4" value="uncategorized">
                            <label class="form-check-label" for="inlineCheckbox4">Uncategorized</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input checkbox-categories-tickets" type="checkbox" id="inlineCheckbox5" value="billing/payments">
                            <label class="form-check-label" for="inlineCheckbox5">Billing/Payments</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input checkbox-categories-tickets" type="checkbox" id="inlineCheckbox6" value="technical question">
                            <label class="form-check-label" for="inlineCheckbox6">Technical Question</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect2">Priority</label>
                        <select class="form-control" id="exampleFormControlSelect2">
                            <option value="high">High</option>
                            <option value="low">Low</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="validatedCustomFile">Attachment (optional)</label>
                        <div class="custom-file mb-3">
                            <input type="file" class="custom-file-input" id="validatedCustomFile">
                            <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                            <div class="invalid-feedback">Example invalid custom file feedback</div>
                        </div>
                    </div>
                    <button class="btn btn-success" type="submit">Create</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push("script")
    <script>
        $(document).ready(function() {
            $('.checkbox-categories-tickets').on('change', function() {
                // Uncheck other checkboxes
                $('.checkbox-categories-tickets').not(this).prop('checked', false);
            });
        });
    </script>
@endpush
