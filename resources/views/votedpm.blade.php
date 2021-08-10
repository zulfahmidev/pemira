<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/popper/popper.min.js') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-5.0.2/dist/css/bootstrap.css') }}">
    <script src="{{ asset('vendor/jquery/jquery-3.6.0.min.js') }}"></script>
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
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-danger" >KELUAR</a>
                </form>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="text-center" style="padding: 5rem 0;">
            <div style="font-size: 32px;" class="text-danger">HALAMAN PEMILIHAN</div>
            <h1>KETUA DEWAN PERWAKILAN MAHASISWA</h1>
        </div>
        <div class="row mb-5">
            @foreach ($cadidates as $cadidate)
                
            <div class="col-lg-4 mb-3">
                <div class="card shadow" style="width: 100%;">
                    <img src="{{ asset('uploads/dpm/foto/'.$cadidate->foto) }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5>{{ $cadidate->nama }}</h5>
                        <p class="small text-black-50">Calon Ketua DPM nomor urut {{ $cadidate->nomor_urut }}.</p>
                        <div class="row">
                            <div class="col-6">
                                <div class="d-grid gap-2">
                                    <button data-bs-toggle="modal" data-bs-target="#detail-{{ $cadidate->nomor_urut }}" class="btn btn-warning"">DETAIL</button>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-grid gap-2">
                                    <button data-bs-toggle="modal" data-bs-target="#vote-{{ $cadidate->nomor_urut }}" class="btn btn-danger"">VOTE</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="detail-{{ $cadidate->nomor_urut }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Detail</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="modal-text">
                                {!! $cadidate->description !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal fade" id="vote-{{ $cadidate->nomor_urut }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Konfirmasi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="modal-text">Apakah anda yakin ingin memilih kandidat nomor urut {{ $cadidate->nomor_urut }}?</div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                        <form action="{{ url('vote/dpm/'.$cadidate->nomor_urut) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-danger">Benar</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>

            @endforeach
        </div>
    </div>
    <div class="py-4 bg-light text-center">
        <div class="small text-black" style="font-size: 12px;">Copyright &copy;2021, Komisi Indepen Pemilihan Politeknik Negeri Lhokseumawe.</div>
    </div>
</body>
</html>