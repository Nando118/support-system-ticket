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
    <div class="container-fluid pb-3">
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
                            <th>Created At</th>
                            <th>Ticket Number</th>
                            <th>Title</th>
                            <th>Label</th>
                            <th>Category</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Engineer</th>
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
                    { data: 'created_at', name: 'created_at', render: DataTable.render.date(), },
                    { data: 'ticket_number', name: 'ticket_number' },
                    { data: 'title', name: 'title' },
                    { data: 'label', name: 'label' },
                    { data: 'category', name: 'category' },
                    { data: 'priority', name: 'priority' },
                    { data: 'status', name: 'status' },
                    { data: 'engineer_id', name: 'engineer' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                order: [2, 'desc'],
            });
        });

        // Action button

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
