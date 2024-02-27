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
    <div class="container pt-2 pb-3">
        <div class="card">
            <div class="card-header font-weight-bold">
                Tickets
            </div>
            <div class="card-body">
                <form id="form_create_ticket" action="{{ route("ticket.store") }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Title<span style="color: red;">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="exampleFormControlInput1" name="title" placeholder="Enter title ticket here..." value="{{ old('title') }}">
                        @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Description<span style="color: red;">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="exampleFormControlTextarea1" rows="5" name="description" placeholder="Describe your problem here..." style="resize: none;">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group group1">
                        <label for="checkbox">Labels<span style="color: red;">*</span></label> <br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input checkbox-group1 @error('labels') is-invalid @enderror" type="checkbox" id="inlineCheckbox1" name="labels[]" value="bug" onchange="handleCheckboxChange(this)">
                            <label class="form-check-label" for="inlineCheckbox1">Bug</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input checkbox-group1 @error('labels') is-invalid @enderror" type="checkbox" id="inlineCheckbox2" name="labels[]" value="question" onchange="handleCheckboxChange(this)">
                            <label class="form-check-label" for="inlineCheckbox2">Question</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input checkbox-group1 @error('labels') is-invalid @enderror" type="checkbox" id="inlineCheckbox3" name="labels[]" value="enhancement" onchange="handleCheckboxChange(this)">
                            <label class="form-check-label" for="inlineCheckbox3">Enhancement</label>
                        </div>
                        @error('labels')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group group2">
                        <label for="checkbox">Categories<span style="color: red;">*</span></label> <br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input checkbox-group2 @error('categories') is-invalid @enderror" type="checkbox" id="inlineCheckbox4" name="categories[]" value="uncategorized" onchange="handleCheckboxChange(this)">
                            <label class="form-check-label" for="inlineCheckbox4">Uncategorized</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input checkbox-group2 @error('categories') is-invalid @enderror" type="checkbox" id="inlineCheckbox5" name="categories[]" value="billing/payments" onchange="handleCheckboxChange(this)">
                            <label class="form-check-label" for="inlineCheckbox5">Billing/Payments</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input checkbox-group2 @error('categories') is-invalid @enderror" type="checkbox" id="inlineCheckbox6" name="categories[]" value="technical question" onchange="handleCheckboxChange(this)">
                            <label class="form-check-label" for="inlineCheckbox6">Technical Question</label>
                        </div>
                        @error('categories')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect2">Priority<span style="color: red;">*</span></label>
                        <select class="form-control @error('priority') is-invalid @enderror" id="exampleFormControlSelect2" name="priority">
                            <option value="" selected disabled>Choose here...</option>
                            <option value="high" {{ old('priority') == "high" ? 'selected' : '' }}>High</option>
                            <option value="low" {{ old('priority') == "low" ? 'selected' : '' }}>Low</option>
                        </select>
                        @error('priority')
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
                    <button id="create_ticket" class="btn btn-success" type="submit">Create</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push("scripts")
    <script>
        // Disabled checkbox jika sudah terpilih salah satunya
        function handleCheckboxChange(checkbox) {
            var $checkboxes;
            // Menentukan grup checkbox berdasarkan kelas
            if ($(checkbox).hasClass('checkbox-group1')) {
                $checkboxes = $(checkbox).closest('.group1').find('.checkbox-group1');
            } else if ($(checkbox).hasClass('checkbox-group2')) {
                $checkboxes = $(checkbox).closest('.group2').find('.checkbox-group2');
            }
            $checkboxes.each(function() {
                if (this !== checkbox) {
                    if (checkbox.checked) {
                        $(this).prop('disabled', true);
                    } else {
                        $(this).prop('disabled', false);
                    }
                }
            });
        }

        // Disabled Button Submit Jika Sudah klik Submit
        $(document).ready(function () {
            $("#form_create_ticket").submit(function (e) {
                // Menonaktifkan tombol submit
                $("#create_ticket").prop("disabled", true);

                // Melakukan pengiriman form secara manual
                // Anda bisa menggunakan AJAX atau langsung submit form
                // Di sini saya menggunakan submit() untuk mengirim form secara langsung
                this.submit();
            });
        });

        // POP UP Message
        @if(session('error_create_ticket'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal membuat ticket!',
                text: '{{ session('error_create_ticket') }}'
            });
        @endif

        // WYSIWYG - Tinymce
        tinymce.init({
            selector: 'textarea',
            menubar: false,
            plugins: 'lists',
            toolbar: 'bold italic underline | bullist numlist',
            placeholder: 'Tell us your problem here...'
        });

    </script>
@endpush
