<template>
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Catatan</h1>
        <p class="mb-4">Halaman ini bersifat rahasia, dimohon untuk yang mengunjungi halaman ini tidak menyebarluaskan.</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row" style="align-items: center;">
                    <div class="col-lg-6">
                        <h6 class="m-0 font-weight-bold text-danger">Daftar Kandidat Ketua DPM</h6>
                    </div>
                    <div class="col-lg-6 text-right">
                        <router-link :to="{name: 'Create Cadidate Dpm', params: []}" class="btn btn-sm btn-primary btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Tambah Kandidat</span>
                        </router-link>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nomor Urut</th>
                                <th>Atas Nama</th>
                                <th>Foto</th>
                                <th>Ubah</th>
                                <th>Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(v,i) in cadidates" :key="i">
                                <td>{{ v.nomor_urut }}</td>
                                <td>{{ v.nama }}</td>
                                <td>
                                    <a :href="`/uploads/dpm/foto/${v.foto}`" target="_blank" rel="noopener noreferrer" class="btn btn-block btn-sm btn-success"><i class="fa fa-eye"></i></a>
                                </td>
                                <td>
                                    <router-link :to="{name: 'Edit Cadidate Dpm', params: {nomor_urut: v.nomor_urut}}" class="btn btn-block btn-sm btn-warning"><i class="fa fa-edit"></i></router-link>
                                </td>
                                <td>
                                    <button @click="remove(v,i)" class="btn btn-block btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            user: null,
            cadidates: [],
        }
    },
    methods: {
        remove(v,i) {
            let conf = confirm('Apakah anda yakin ingin menghapus kandidat nomor ' + v.nomor_urut);
            if (conf) {
                axios.delete(`/cadidate/dpm/${v.nomor_urut}?token=${this.user.token}`)
                .then(r => {
                    this.cadidates.splice(i,1);
                    console.log(r)
                })
                .catch(e => {
                    console.dir(e);
                })
            }
        },
        getData(v) {
            return {
                nomor_urut: v.nomor_urut,
                nama: v.nama,
                foto: '',
                description: v.description,
            }
        }
    },
    mounted() {
        const userInfo = localStorage.getItem('user')
        if (!userInfo) {
            location.replace('/manager/login');
        }
        this.user = JSON.parse(userInfo);
        console.log(this.user.token)
        axios.get('/cadidate/dpm')
        .then(r => {
            this.cadidates = r.data.body;
        })
        .catch(e => {
            console.dir(e);
        })
    }
}
</script>