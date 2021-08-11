<template>
    <div class="container">

        <div class="row justify-content-center align-items-center">

            <div class="col-xl-5 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="p-5">
                            <div class="text-center">
                                <img src="/img/LOGO KIP.png" width="80" height="80" alt="Logo KIP">
                                <h1 class="h4 text-gray-900 mb-4 mt-3">Welcome Back!</h1>
                                <div class="alert alert-danger" v-if="error">{{ error }}</div>
                            </div>
                            <div class="user">
                                <div class="form-group">
                                    <input type="text" v-model="name" class="form-control form-control-user" placeholder="Enter Name...">
                                    <small class="text-danger" v-for="(v,i) in errors.name" :key="i">{{ v }}</small>
                                </div>
                                <div class="form-group">
                                    <input type="password" @keydown.enter="login" v-model="password" class="form-control form-control-user" placeholder="Password">
                                    <small class="text-danger" v-for="(v,i) in errors.password" :key="i">{{ v }}</small>
                                </div>
                                <button @click="login" class="btn btn-danger btn-user btn-block">
                                    Login
                                </button>
                            </div>
                        </div>
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
            name: '',
            password: '',
            errors: {
                name: [],
                password: [],
            },
            error: false,
        }
    },
    methods: {
        login() {
            this.$store.dispatch('login', {
                credentials: {
                    name: this.name,
                    password: this.password,
                },
                callback: (r) => {
                    if (r.status == 403) {
                        this.error = "Maaf, anda tidak diizinkan untuk masuk!"
                    }else if(r.status == 200) {
                        location.replace('/manager/voters');
                    }
                },
            }).catch(e => {
                console.dir(e)
                let r = e.response;
                this.errors = {
                    name: [],
                    password: [],
                };
                if (r.status == 403) {
                    if (r.data.message == "Invalid field") {
                        let data = r.data.body;
                        for (const key in data) {
                            if (Object.hasOwnProperty.call(data, key)) {
                                const val = data[key];
                                this.errors[key] = val;
                            }
                        }
                    }else {
                        this.error = r.data.message;
                    }
                } else {
                    this.error = "Email atau Password anda salah!";
                }
            });
        },
    },
    mounted() {
        const userInfo = localStorage.getItem('user')
        if (userInfo) {
            const userData = JSON.parse(userInfo)
            let date = new Date();
            let time = parseInt(`${date.getTime()}`.split('').slice(0,10).join(''));
            this.$store.commit('setUserData', userData)
            this.login = true;
            if (time >= parseInt(userData.expired_at)) {
                dispatch('logout')
            }
            location.replace('/manager/voters');
            axios.interceptors.response.use(
            response => response,
            error => {
                if (error.response.status === 401) {
                dispatch('logout')
                }
                return Promise.reject(error)
            }
            )
        }
    }
}
</script>