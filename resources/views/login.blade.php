<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-5.0.2/dist/css/bootstrap.css') }}">
    <script src="{{ asset('vendor/jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('vendor/popper/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-5.0.2/dist/js/bootstrap.min.js') }}"></script>
</head>
<body class="">
    <div class="navbar navbar-expand-lg navbar-light shadow bg-white">
        <div class="container">
            <div class="navbar-brand d-flex" style="align-items: center;">
                <div class="logo">
                    <img src="{{ asset('img/LOGO KIP.png') }}" alt="...">
                </div>
                <div class="px-3">Komisi Indepen Pemilihan</div>
            </div>
            <div class="d-flex">
                <a href="/" class="btn btn-danger" style="margin-left: 1rem;">BERANDA</a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row my-2">
            <div class="col-lg-5 mx-auto">
                <div class="w-100 rounded shadow px-5 py-5 bg-white my-5">
                    <div class="text-center py-3">
                        <div class="h3">SILAHKAN LOGIN</div>
                        <p class="text-black-50">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    </div>
                    @if (session('error'))
                        <div class="alert alert-danger text-left">{{ session('error') }}</div>
                    @endif
                    <form action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="form-group mt-3">
                            <input type="text" placeholder="Masukkan nim" name="nim" class="form-control">
                            @error('nim')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <input type="password" placeholder="Masukkan password" name="password" class="form-control">
                            @error('password')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-grid mt-3 mb-5">
                            <button type="submit" class="btn btn-danger">MASUK</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="py-4 bg-light text-center">
        <div class="small text-black" style="font-size: 12px;">Copyright &copy;2021, Komisi Indepen Pemilihan Politeknik Negeri Lhokseumawe.</div>
    </div>

</body>
</html>