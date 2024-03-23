@extends('dashboard.layouts.main-layouts')

@section('content_header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route("home.index") }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route("users.index") }}">Users</a></li>
            @if(isset($user_data))
                <li class="breadcrumb-item active" aria-current="page">Update User</li>
            @else
                <li class="breadcrumb-item active" aria-current="page">Create New User</li>
            @endif
        </ol>
    </nav>

@endsection

@section('content')
    <div class="container pt-2 pb-3">
        <div class="card">
            <div class="card-header font-weight-bold">
                @if(isset($user_data))
                    Update User
                @else
                    New User
                @endif
            </div>
            <div class="card-body">
                <form id="form_create_user" action="{{ $action }}" method="POST">
                    @csrf
                    @if(isset($user_data))
                        <input type="hidden" id="user_id" name="user_id" value="{{ $user_data->id }}">
                    @endif
                    <div class="form-group">
                        <label for="formGroupExampleInput">Name<span style="color: red;">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="formGroupExampleInput" name="name" value="{{ old('name') ?? (isset($user_data) ? $user_data->name : "") }}">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>@if(!isset($user_data))<span style="color: red; font-weight: bolder;">*</span>@endif
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" name="email" value="{{ old('email') ?? (isset($user_data) ? $user_data->email : "") }}" @isset($user_data) readonly @endisset>
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>@if(!isset($user_data))<span style="color: red; font-weight: bolder;">*</span>@endif
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="exampleInputPassword1" name="password" value="{{ old('password') }}">
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect2">Role<span style="color: red;">*</span></label>
                        <select class="form-control @error('role') is-invalid @enderror" id="exampleFormControlSelect2" name="role">
                            <option value="" selected disabled>Choose here...</option>
                            <option value="super_admin" {{ old('role') == "super_admin" ? 'selected' : (isset($user_data) && $user_data->role == "super_admin" ? 'selected' : '') }}>Super Admin</option>
                            <option value="engineer" {{ old('role') == "engineer" ? 'selected' : (isset($user_data) && $user_data->role == "engineer" ? 'selected' : '') }}>Engineer</option>
                            <option value="regular_user" {{ old('role') == "regular_user" ? 'selected' : (isset($user_data) && $user_data->role == "regular_user" ? 'selected' : '') }}>Regular User</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <button id="create_user" class="btn btn-success" type="submit">Create</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push("scripts")
    <script>
        // Disabled Button Submit Jika Sudah klik Submit
        $(document).ready(function () {
            $("#form_create_user").submit(function (e) {
                // Menonaktifkan tombol submit
                $("#create_user").prop("disabled", true);

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
