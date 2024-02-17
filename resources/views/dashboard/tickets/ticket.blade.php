@extends('dashboard.layouts.main-layouts')

@section('content_header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route("home.index") }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tickets</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Tickets
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tbl_list" class="table table-striped" width="100%">
                        <thead>
                        <tr >
                            <th>No</th>
                            <th>Ticket Number</th>
                            <th>Title</th>
                            <th>Label</th>
                            <th>Category</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                @can("create-ticket")
                    <a href="{{ route("ticket.create") }}" class="btn btn-success">Create Ticket</a>
                @endcan
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
                ajax: '{{ route('ticket.index') }}',
                language: {
                    zeroRecords: "There is no ticket data yet",
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
                    { data: 'ticket_number', name: 'ticket_number' },
                    { data: 'title', name: 'title' },
                    { data: 'label', name: 'label' },
                    { data: 'category', name: 'category' },
                    { data: 'priority', name: 'priority' },
                    { data: 'status', name: 'status' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                columnDefs: [
                    {
                        target: 7,
                        render: DataTable.render.date()
                    },
                ],
                order: [7, 'desc'],
            });
        });

        // Action button
        $('#tbl_list').on('click', '.delete', function (){
            const el = $(this);
            Swal.fire({
                icon: 'warning',
                title: 'Delete Employee Data',
                text: "Are you sure you want to delete this employee data?",
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
                                text: 'Employee data has been successfully deleted!',
                            });
                        }
                        else {
                            Swal.fire({
                                icon: 'error',
                                title: 'ERROR',
                                text: 'Employee data failed to delete!',
                            });
                        }
                    });
                }
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

        @if(session('success_create_ticket'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil membuat ticket!',
                text: '{{ session('success_create_ticket') }}'
            });
        @endif
    </script>
@endpush
