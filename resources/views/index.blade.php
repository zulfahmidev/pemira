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
    <script src="{{ asset('vendor/axios/axios.min.js') }}"></script>
    <script src="{{ asset('vendor/vue/vue.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-5.0.2/dist/js/bootstrap.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <div class="navbar-brand d-flex" style="align-items: center;">
                <div class="logo">
                    <img src="{{ asset('img/LOGO KIP.png') }}" alt="...">
                </div>
                <div class="px-3 d-none d-lg-block">Komisi Indepen Pemilihan</div>
            </div>
            <div class="d-flex">
                <a href="#howVote" class="btn btn-light">CARA VOTING</a>
                <a href="{{ route('login') }}" class="btn btn-danger" style="margin-left: 1rem;">VOTE NOW!</a>
            </div>
        </div>
    </div>
    <div class="bg-light" id="header">
        <section>
            <div class="container text-center py-5">
                <h1>PEMILIHAN RAYA</h1>
                <h3 class="text-danger">POLITEKNIK NEGERI LHOKSEUMAWE</h2>
                <p>Satu suara dalam mewujudkan pemimpin yang berkarakter dengan semangat persatuan di era normal baru.</p>
                <div class="row my-5">
                    <div class="col-lg-6 m-auto">
                        <div class="row" id="timevote">
                            <div class="col-3 text-center">
                                <div class="box bg-danger m-auto text-white" id="days">
                                    0
                                </div>
                                <div class="h5 mt-2">HARI</div>
                            </div>
                            <div class="col-3 text-center">
                                <div class="box bg-danger m-auto text-white" id="hours">
                                    0
                                </div>
                                <div class="h5 mt-2">JAM</div>
                            </div>
                            <div class="col-3 text-center">
                                <div class="box bg-danger m-auto text-white" id="minutes">
                                    0
                                </div>
                                <div class="h5 mt-2">MENIT</div>
                            </div>
                            <div class="col-3 text-center">
                                <div class="box bg-danger m-auto text-white" id="seconds">
                                    0
                                </div>
                                <div class="h5 mt-2">DETIK</div>
                            </div>
                        </div>
                        <p id="descTime" class="my-3" style="opacity: .5">SISA WAKTU UNTUK MULAI VOTING</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="container text-center py-5">
        <h2>QUICK COUNT DPM</h2>
        <p class="text-black-50">Hasil perhitangan suara secara realtime dari pemilihan Ketua DPM.</p>
        <div class="row">
            <div class="col-lg-6 m-auto">
                <canvas id="hasilSuaraDpm"></canvas>
            </div>
            <div class="col-lg-6 text-start px-4">
                {{-- <canvas id="hasilSuaraBem"></canvas> --}}
                <h4>Laporan Pemilih:</h4>
                <table class="table">
                    <tr>
                        <td>Jumlah pemilih yang terdaftar</td>
                        <td class="total_voters">0</td>
                    </tr>
                    <tr>
                        <td>Jumlah yang telah memberi suara</td>
                        <td class="hasVotesDPM">0</td>
                    </tr>
                    <tr>
                        <td>Jumlah yang belum memberi suara</td>
                        <td class="notVotesDPM">0</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="container text-center py-5">
        <h2>QUICK COUNT BEM</h2>
        <p class="text-black-50">Hasil perhitangan suara secara realtime dari pemilihan Ketua dan WAKIL BEM.</p>
        <div class="row">
            <div class="col-lg-6 m-auto">
                <canvas id="hasilSuaraBem"></canvas>
            </div>
            <div class="col-lg-6 text-start px-4">
                {{-- <canvas id="hasilSuaraBem"></canvas> --}}
                <h4>Laporan Pemilih:</h4>
                <table class="table">
                    <tr>
                        <td>Jumlah pemilih yang terdaftar</td>
                        <td class="total_voters">0</td>
                    </tr>
                    <tr>
                        <td>Jumlah yang telah memberi suara</td>
                        <td class="hasVotesBEM">0</td>
                    </tr>
                    <tr>
                        <td>Jumlah yang belum memberi suara</td>
                        <td class="notVotesBEM">0</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div id="howVote" class="container text-center py-5">
        <h2>CARA VOTING</h2>
        <p class="text-black-50">Lorem ipsum dolor, sit amet consectetur adipisicing elit.</p>
        <div class="row">
            <div class="col-lg-6 m-auto">

                <div class="ratio ratio-16x9">
                    <iframe src="https://www.youtube.com/embed/KO4xEQ3" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>

    <div class="py-4 bg-light text-center">
        <div class="small text-black" style="font-size: 12px;">Copyright &copy;2021, Komisi Indepen Pemilihan Politeknik Negeri Lhokseumawe.</div>
    </div>
    
    <!-- Modals -->
    <div class="modal fade" id="modalLogin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Silahkan Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="main">NIM: </label>
                        <input type="text" id="main" v-model="primary_form" placeholder="Ketik disini..." class="form-control">
                    </div>
                    <div class="form-group mt-2">
                        <label for="password">Password: </label>
                        <input type="password" @keydown.enter="login" v-model="password" id="password" placeholder="Ketik disini..." class="form-control">
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-danger my-2" @click="login">MASUK</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        let start = {{ $start }};
        let end = {{ $end }};
        setInterval(() => {
            let date = new Date();
            let now = (Math.floor(date.getTime() / 1000) - 1);
            // let time = (start > now ? start : end) - now;
            if (start > now) {
                time = start - now;
                document.querySelector('#descTime').innerHTML = 'SISA WAKTU UNTUK MULAI VOTING';
            }else {
                time = end - now;
                document.querySelector('#descTime').innerHTML = 'SISA WAKTU UNTUK MELAKUKAN VOTING';
            }
            updateTime(time);
        }, 20);
    </script>
</body>
</html>