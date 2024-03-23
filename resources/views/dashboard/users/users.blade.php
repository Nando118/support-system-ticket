@extends('dashboard.layouts.main-layouts')

@section('content_header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route("home.index") }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Users</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="container-fluid pb-3">
        <div class="card">
            <div class="card-header font-weight-bold">
                Users
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tbl_list" class="table table-striped" width="100%">
                        <thead>
                        <tr >
                            <th>No</th>
                            <th>Created At</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route("users.create") }}" class="btn btn-success">Add New User</a>
            </div>
        </div>
    </div>
@endsection

@push("scripts")
    <script type="text/javascript">
        // Datatables
        $(document).ready(function () {
            $('#tbl_list').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('users.index') }}',
                language: {
                    zeroRecords: "There is no users data yet",
                },
                columns: [
                    {
                        data: null,
                        name: 'no',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row, meta) {
                            // Menampilkan nomor index (incremented by 1) pada setiap baris
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { data: 'created_at', name: 'created_at', render: DataTable.render.date(), },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'role', name: 'role' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                order: [1, 'desc'],
            });
        });

        // Action button
        $('#tbl_list').on('click', '.delete', function (){
            const el = $(this);
            Swal.fire({
                icon: 'warning',
                title: 'Hapus data pengguna!',
                text: "Apakah Anda yakin ingin menghapus data pengguna ini?",
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if(result.value){
                    $('.loading').show();
                    $.ajax({
                        url: el.data('url'),
                        type: 'DELETE',
                        dataType: 'JSON',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        }
                    }).always(function (){
                        $('.loading').hide();
                    }).done(function (data) {
                        if(data.success){
                            $('#tbl_list').DataTable().ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Data pengguna berhasil dihapus!',
                            });
                        }
                        else {
                            Swal.fire({
                                icon: 'error',
                                title: 'ERROR',
                                text: 'Data pengguna gagal dihapus!',
                            });
                        }
                    });
                }
            });
        });

        // POP UP Message
        @if(session('error_create_new_user'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal menambahkan pengguna baru!',
                text: '{{ session('error_create_new_user') }}'
            });
        @endif

        @if(session('error_update_user'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal mengubah data pengguna!',
                text: '{{ session('error_update_user') }}'
            });
        @endif

        @if(session('success_create_new_user'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil menambahkan pengguna baru!',
                text: '{{ session('success_create_new_user') }}'
            });
        @endif

        @if(session('success_update_user'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil mengubah data pengguna!',
                text: '{{ session('success_update_user') }}'
            });
        @endif
    </script>
@endpush
