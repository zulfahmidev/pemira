<template>
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Catatan</h1>
        <p class="mb-4">Halaman ini bersifat rahasia, dimohon untuk yang mengunjungi halaman ini tidak menyebarluaskan.</p>

        <!-- DataTales Example -->
        <div class="row">
            <div class="col-lg-4">
                <div class="h5 mb-3"># Jadwal Voting</div>
                <label for="start">Jadwal Buka:</label>
                <div class="input-group mb-3">
                    <input type="datetime-local" id="start" v-model="start" class="form-control">
                    <div class="input-group-append">
                        <button class="btn btn-danger btn-sm" @click="saveStart"><i class="fa fa-fw fa-save"></i></button>
                    </div>
                </div>
                <label for="end">Jadwal Tutup:</label>
                <div class="input-group">
                    <input type="datetime-local" id="end" v-model="end" class="form-control">
                    <div class="input-group-append">
                        <button class="btn btn-danger btn-sm" @click="saveEnd"><i class="fa fa-fw fa-save"></i></button>
                    </div>
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
            start: '',
            end: '',
        }
    },
    methods: {
        saveStart() {
            let date = new Date(this.start);
            let time = (Math.floor(date.getTime() / 1000));
            axios.post('/setting?token='+this.user.token, {
                key: 'start_voting',
                value: time,
            })
            .then(r => {
                console.log(r);
            })
        },
        saveEnd() {
            let date = new Date(this.end);
            let time = (Math.floor(date.getTime() / 1000));
            axios.post('/setting?token='+this.user.token, {
                key: 'end_voting',
                value: time,
            })
            .then(r => { 
                console.log(r);
            })
            .catch(e => {
                console.dir(e);
            })
        },
        format(v) {
            let d = new Date(v);
            return `${this.addZero(d.getFullYear())}-${this.addZero(d.getMonth())}-${this.addZero(d.getDate())} ${this.addZero(d.getHours())}:${this.addZero(d.getMinutes())}:${this.addZero(d.getSeconds())}`;
        },
        reformat(v) {
            let d = new Date(v);
            return `${this.addZero(d.getFullYear())}-${this.addZero(d.getMonth())}-${this.addZero(d.getDate())}T${this.addZero(d.getHours())}:${this.addZero(d.getMinutes())}:${this.addZero(d.getSeconds())}`;
        },
        addZero(number) {
            if (number < 10 && number > -10) {
                return '0'+number;
            }
            return number;
        }
    },
    mounted() {
        const userInfo = localStorage.getItem('user')
        if (!userInfo) {
            location.replace('/manager/login');
        }
        this.user = JSON.parse(userInfo);
        axios.get('/setting/start_voting')
        .then(r => {
            if (this.start != null) {
                this.start = this.reformat((parseInt(r.data.body)*1000))
            }
        })
        axios.get('/setting/end_voting')
        .then(r => {
            if (this.end != null) {
                this.end = this.reformat((parseInt(r.data.body)*1000))
            }
        })
    }
}
</script>