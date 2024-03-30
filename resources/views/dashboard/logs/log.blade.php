@extends('dashboard.layouts.main-layouts')

@section('content_header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route("home.index") }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Logs</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="container-fluid pb-3">
        <div class="card">
            <div class="card-header font-weight-bold">
                Logs
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tbl_list" class="table table-striped" width="100%">
                        <thead>
                        <tr >
                            <th>No</th>
                            <th>Ticket Number</th>
                            <th>User Email</th>
                            <th>Type</th>
                            <th>Activity Description</th>
                            <th>Created At</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">

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
                ajax: '{{ route('log.index') }}',
                language: {
                    zeroRecords: "There is no ticket log data here",
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
                    { data: 'ticket_id', name: 'ticket_id' },
                    { data: 'user_id', name: 'user_id' },
                    {
                        data: 'type',
                        name: 'type',
                        render: function (data, type, row) {
                            var badgeClass = "";
                            if (data === "CREATE") {
                                badgeClass = "badge badge-success";
                            }else if (data === "ASSIGN") {
                                badgeClass = "badge badge-primary";
                            }else if (data === "REPLY") {
                                badgeClass = "badge badge-info";
                            }else if (data === "CLOSED") {
                                badgeClass = "badge badge-secondary";
                            }else {
                                badgeClass = "badge";
                            }
                            return '<span class="' + badgeClass + '">' + data + '</span>';
                        }
                    },
                    { data: 'activity', name: 'activity' },
                    { data: 'created_at', name: 'created_at', render: DataTable.render.date(), }
                ],
                order: [5, 'desc'],
            });
        });
    </script>
@endpush
