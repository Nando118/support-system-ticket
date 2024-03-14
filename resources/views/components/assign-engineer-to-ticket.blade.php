@section('content_header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

<div>
    <!-- Act only according to that maxim whereby you can, at the same time, will that it should become a universal law. - Immanuel Kant -->
    <div class="btn-group">
        <a href="{{ route("ticket.comments.index", ["id" => $id]) }}" class="btn btn-primary btn-sm" title="View Reply"><i class="fa-regular fa-comments"></i><p style="position: absolute; top: -5px; right: -5px; z-index: 50" class="text-bold badge badge-danger d-flex">99</p></a>
        @can("assign-ticket")
            <button type="button" class="btn btn-info btn-sm assign-engineer-btn" title="Assign Engineer" data-toggle="modal" data-target="#exampleModal-{{ $id }}" data-ticket-id="{{ $id }}"  @if($status === "Closed") disabled @endif><i class="fa-solid fa-user"></i></button>
        @endcan
        <button type="button" class="btn btn-success btn-sm close-ticket-btn" title="Close Ticket" data-ticket-id="{{ $id }}" @if($status === "Closed") disabled @endif><i class="fa-solid fa-check"></i></button>
    </div>
</div>

<div>
    <!-- Happiness is not something readymade. It comes from your own actions. - Dalai Lama -->
    <div class="modal fade" id="exampleModal-{{ $id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        @csrf
                        <div class="form-group">
                            <input type="hidden" id="ticket_id" name="ticket_id" value="{{ $id }}">
                            <label for="exampleFormControlSelect2">Engineer<span style="color: red;">*</span></label>
                            <select class="form-control custom-select" id="exampleFormControlSelect2" name="engineer" required>
                                @foreach($engineers as $engineer)
                                    <option value="{{ $engineer->id }}">
                                        {{ $engineer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-assign">Assign</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Assign Engineer
    $(document).ready(function () {
        $(".btn-assign").off("click").on("click", function () {
            var ticketId = $(this).closest('.modal').find('#ticket_id').val();
            var engineerId = $(this).closest('.modal').find('#exampleFormControlSelect2').val();

            // Tampilkan konfirmasi menggunakan SweetAlert2
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan menugaskan engineer untuk tiket ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika pengguna menekan tombol "Yes", kirim request AJAX
                    $.ajax({
                        url: "{{ route('ticket.assign') }}",
                        type: "POST",
                        data: {
                            ticket_id: ticketId,
                            engineer_id: engineerId,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            // Tindakan setelah pembaruan berhasil
                            // Setelah tombol OK Swal diklik, perbarui tabel atau lakukan tindakan lain yang diperlukan
                            $('#tbl_list').DataTable().ajax.reload();
                            Swal.fire({
                                title: 'Success!',
                                text: 'Berhasil menetapkan Engineer untuk ticket ini!.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                            // Hapus backdrop modal secara manual
                            $('.modal-backdrop').remove();
                            // console.log(response);
                        },
                        error: function (xhr) {
                            // Tindakan jika terjadi kesalahan
                            Swal.fire({
                                title: 'Error!',
                                text: 'Gagal menetapkan Engineer untuk ticket ini. Silahkan coba lagi nanti!',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                            // console.log(xhr.responseText);
                        }
                    });
                }
            });
        });
    });

    // Close Ticket
    $(document).ready(function() {
        // Event handler for Close Ticket button click
        $(".close-ticket-btn").click(function() {
            var ticketId = $(this).data("ticket-id");
            var url = "{{ route('ticket.close') }}";
            var csrfToken = $('meta[name="csrf-token"]').attr('content'); // Ambil token CSRF

            // Tampilkan pesan konfirmasi menggunakan SweetAlert2
            Swal.fire({
                title: 'Tutup Ticket',
                text: "Apakah Anda yakin ingin menutup ticket ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika pengguna menekan tombol "Yes", kirim permintaan AJAX untuk menutup tiket
                    $.ajax({
                        url: url,
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': csrfToken // Sertakan token CSRF dalam header permintaan
                        },
                        data: {
                            ticket_id: ticketId
                        },
                        success: function(response) {
                            // Handle success response
                            // Tindakan setelah pembaruan berhasil
                            // Setelah tombol OK Swal diklik, perbarui tabel atau lakukan tindakan lain yang diperlukan
                            $('#tbl_list').DataTable().ajax.reload();
                            Swal.fire({
                                title: 'Success!',
                                text: 'Berhasil menutup ticket ini!.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                            // Hapus backdrop modal secara manual
                            $('.modal-backdrop').remove();
                            // console.log(response);
                        },
                        error: function(xhr, status, error) {
                            // Handle error response
                            // console.error("Failed to close ticket:", error);
                            // Tindakan jika terjadi kesalahan
                            Swal.fire({
                                title: 'Error!',
                                text: 'Gagal menutup ticket ini. Silahkan coba lagi nanti!',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                            // console.log(xhr.responseText);
                        }
                    });
                }
            });
        });
    });
</script>




