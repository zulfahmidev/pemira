import {createStore} from 'vuex';
import axios from 'axios';

axios.defaults.baseURL = "/api/";
// const added_data_axios = {
//     token: '..some_data..'
// };

// const api = axios.create({
//     transformRequest: [(data) => {
//         return {...added_data_axios, ...data};
//     }, ...axios.defaults.transformRequest],
// });

export default createStore({
    state: {
        user: null,
    },

    mutations: {
        setUserData (state, userData) {
            localStorage.setItem('user', JSON.stringify(userData.body));
            axios.defaults.headers.common = {
                token: userData.token,
              };
            this.state.user = userData.body;
        },

        clearUserData() {
            localStorage.removeItem('user');
            location.reload();
        }
    },

    actions: {
        login({commit}, request) {
            return axios
            .post('/admin/login', request.credentials)
            .then(({ data }) => {
                commit('setUserData', data)
                request.callback({
                    status: 200,
                    data,
                }) 
            });
        },
        checklogged() {
            const userInfo = localStorage.getItem('user')
            if (userInfo) {
              const userData = JSON.parse(userInfo)
              let date = new Date();
              let time = parseInt(`${date.getTime()}`.split('').slice(0,10).join(''));
              commit('setUserData', userData)
              this.login = true;
              if (time >= parseInt(userData.expired_at)) {
                  dispatch('logout')
              }
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
        },
        logout({commit}) {
            const userInfo = localStorage.getItem('user');
            let user = JSON.parse(userInfo)
            axios.post('/admin/logout', {
                token: user.token,
            })
            .then(r => {
                commit('clearUserData');
            })
            .catch(e => {
                commit('clearUserData');
            })
        },
    },

    getters: {
        isLogged: state => !!state.user,
    }
});