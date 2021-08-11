<template>
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Catatan</h1>
        <p class="mb-4">Halaman ini bersifat rahasia, dimohon untuk yang mengunjungi halaman ini tidak menyebarluaskan.</p>

        <!-- DataTales Example -->
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="nomor urut">Nomor Urut:</label>
                    <input type="number" id="nomor urut" v-model="form.nomor_urut" class="form-control" placeholder="nomor urut...">
                    <div class="small text-danger mt-1" v-for="(error,i) in errors.nomor_urut" :key="i">{{ error }}</div>
                </div>
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <input type="text" id="nama" v-model="form.nama" class="form-control" placeholder="nama...">
                    <div class="small text-danger mt-1" v-for="(error,i) in errors.nama" :key="i">{{ error }}</div>
                </div>
                <div class="form-group">
                    <label for="nama">Gambar:</label>
                    <div class="custom-file">
                        <input type="file" ref="image" class="custom-file-input" id="gambar" @change="handleImage">
                        <label class="custom-file-label" ref="imageLabel" for="validatedCustomFile">Choose file...</label>
                        <div class="small text-danger mt-1" v-for="(error,i) in errors.foto" :key="i">{{ error }}</div>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-danger btn-sm" @click="send">Tambahkan</button>
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
            form: {
                nama: '',
                nomor_urut: '',
                foto: null,
                description: 'test',
            },
            errors: {
                nama: [''],
                nomor_urut: [''],
                foto: [],
                description: [],
            }
        }
    },
    methods: {
        handleImage() {
            this.form.foto = this.$refs.image.files[0];
            this.$refs.imageLabel.innerHTML = this.form.foto.name;
        },
        send() {
            let fd = new FormData();
            fd.append('nama', this.form.nama);
            fd.append('nomor_urut', this.form.nomor_urut);
            fd.append('foto', this.form.foto);
            fd.append('description', this.form.description);
            axios.post(`/cadidate/bem?token=${this.user.token}`, fd)
            .then(r => {
                this.$router.push({name: "Cadidate Bem", params: []})
            })
            .catch(e => {
              let r = e.response;
              if (r) {
                let data = r.data.body;
                this.errors = {
                    nama: [],
                    nomor_urut: [],
                    foto: [],
                    description: [],
                }
                for (const key in data) {
                    if (Object.hasOwnProperty.call(data, key)) {
                        const val = data[key];
                        this.errors[key] = val;
                    }
                }
              }
            })
        }
    },
    mounted() {
        const userInfo = localStorage.getItem('user')
        if (!userInfo) {
            location.replace('/manager/login');
        }
        this.user = JSON.parse(userInfo);
    }
}
</script>