<template>
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Catatan</h1>
        <p class="mb-4">Halaman ini bersifat rahasia, dimohon untuk yang mengunjungi halaman ini tidak menyebarluaskan.</p>

        <!-- DataTales Example -->
        <div class="row">
            <div class="col-lg-4">
                <div class="card shadow mb-4 p-3">
                    <div class="inputGroupFile04">Import Pemilih:</div>
                    <div class="input-group mt-2">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" ref="file" id="inputGroupFile04" @change="handleFile">
                            <label class="custom-file-label" ref="fileLabel" for="inputGroupFile04">Choose file</label>
                        </div>
                        <div class="input-group-append">
                            <button class="btn btn-danger" @click="import" type="button">Import</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card shadow mb-4 p-3">
                    <div class="">Broadcast Password:</div>
                    <div class="mt-2">
                        <button @click="broadcast" class="btn btn-danger btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fa fa-broadcast-tower"></i>
                            </span>
                            <span class="text">Bagikan Password</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card shadow mb-4 p-3">
                    <div class="">Jumlah Pemilih:</div>
                    <div class="mt-2">
                        <div class="btn btn-primary btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fa fa-users"></i>
                            </span>
                            <span class="text">{{ voters }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="loadingBroadcast" ref="loading">
            <div class="inner">
                <div class="icon"><i class="fa fa-fw fa-broadcast-tower"></i></div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</template>

<script>
import swal from 'sweetalert';
export default {
    data() {
        return {
            user: null,
            fileVoters: '',
            voters: 0,
        }
    },
    methods: {
        handleFile() {
            this.fileVoters = this.$refs.file.files[0];
            this.$refs.fileLabel.innerHTML = this.fileVoters.name;
        },
        import() {
            let fd = new FormData();
            fd.append('voters', this.fileVoters);
            axios.post(`/voter/import?token=${this.user.token}`, fd)
            .then(r => {
                this.updateVoters();
                swal({
                    title: "Berhasil!",
                    text: "Para pemilih berhasil terdaftar!",
                    icon: "success",
                });
            })
            .catch(e => {
                console.dir(e);
            })
        },
        broadcast() {
            this.$refs.loading.classList.add('show')
            axios.post(`/voter/broadcast_password?token=${this.user.token}`)
            .then(r => {
                this.$refs.loading.classList.remove('show')
                swal({
                    title: "Berhasil!",
                    text: "Password berhasil terkirim!",
                    icon: "success",
                });
            })
            .catch(e => {
                console.dir(e);
            })
        },
        updateVoters() {
            axios.get('/quickcount')
            .then(r => {
                this.voters = r.data.body.voters;
            })
        }
    },
    mounted() {
        const userInfo = localStorage.getItem('user')
        if (!userInfo) {
            location.replace('/manager/login');
        }
        this.user = JSON.parse(userInfo);
        this.updateVoters();
    }
}
</script>

<style>

.loadingBroadcast {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0,0,0,.7);
    z-index: 99;
    display: none;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 40px;
}
.loadingBroadcast.show {
    display: flex;
}
.loadingBroadcast .icon {
    animation: loading 1s infinite;
}

@keyframes loading {
    0% {
        transform: translateY(0);
    }
    25% {
        transform: translateY(40px) rotateY(80deg);
    }
    50% {
        transform: translateY(0px);
    }
    100% {
        transform: translateY(0);
    }
}
</style>