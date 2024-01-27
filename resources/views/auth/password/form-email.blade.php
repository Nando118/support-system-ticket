<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title_page }}</title>

    {{--  Fav Icon  --}}
    <link rel="icon" href="{{ asset("img/paimon.ico") }}" type="image/x-icon">

    {{--  BOOTSTRAP CSS  --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <style>

        @font-face {
            font-family: 'zh-cn'; /* Choose a suitable font name */
            src: url("{{ asset('font/zh-cn.ttf') }}") format('truetype');
            /* Add additional font formats (e.g., woff2, ttf) as needed */
        }

        body {
            background-image: url("{{ asset('img/login_image.png') }}");
            background-size: cover;
            font-family: 'zh-cn', sans-serif;
        }
    </style>

</head>
<body>

<div class="container-fluid vh-100 d-flex align-items-center" style="background-color: hsla(0, 0%, 0%, 0.4);">
    <div class="container">
        <div class="row d-flex align-items-center justify-content-center">
            <div class="col-12 col-md-6">
                <div class="card px-3">
                    <div class="card-body">
                        <div class="card-img text-center mb-3">
                            <img class="mb-4" src="{{ asset("img/hoyoverse-logo.png") }}" alt="hoyoverse-logo.png" style="max-width: 50%;"/>
                        </div>
                        <form action="{{ route("password.email") }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" name="email" placeholder="Enter email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <button type="submit" class="btn w-100 btn-success mt-2 mb-3">Check</button>

                            <div class="form-group text-center">
                                Already have account? <a href="{{ route("login.index") }}" class="text-decoration-none">Login here</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{--  BOOTSTRAP JS  --}}
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

{{-- Sweetalert2 CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Tampilkan SweetAlert2 ketika ada pesan error dari server
    @if(session('send_reset_link_failed'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal mengirim link!',
            text: '{{ session('send_reset_link_failed') }}'
        });
    @endif

    @if(session('send_reset_link_success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil mengirim link!',
            text: '{{ session('send_reset_link_success') }}'
        });
    @endif
</script>

</body>
</html>
