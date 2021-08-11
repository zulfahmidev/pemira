import { createRouter, createWebHistory } from 'vue-router'

import CadidateBEM from '../views/CadidateBEM.vue';
import CadidateDPM from '../views/CadidateDPM.vue';
import CreateCadidateDPM from '../views/CreateCadidateDPM.vue';
import CreateCadidateBEM from '../views/CreateCadidateBEM.vue';
import EditCadidateDPM from '../views/EditCadidateDPM.vue';
import EditCadidateBEM from '../views/EditCadidateBEM.vue';
import Settings from '../views/Settings.vue';
import Voters from '../views/Voters.vue';

const router = createRouter({
  history: createWebHistory('/manager'),
  routes: [
    {
      path: '/cadidate/dpm',
      name: 'Cadidate Dpm',
      component: CadidateDPM,
    },
    {
      path: '/cadidate/dpm/create',
      name: 'Create Cadidate Dpm',
      component: CreateCadidateDPM,
    },
    {
      path: '/cadidate/dpm/:nomor_urut/edit',
      name: 'Edit Cadidate Dpm',
      props: true,
      component: EditCadidateDPM,
    },
    {
      path: '/cadidate/bem',
      name: 'Cadidate Bem',
      component: CadidateBEM,
    },
    {
      path: '/cadidate/bem/create',
      name: 'Create Cadidate Bem',
      component: CreateCadidateBEM,
    },
    {
      path: '/cadidate/bem/:nomor_urut/edit',
      name: 'Edit Cadidate Bem',
      props: true,
      component: EditCadidateBEM,
    },
    {
      path: '/voters',
      name: 'Voters',
      component: Voters,
    },
    {
      path: '/settings',
      name: 'Settings',
      component: Settings,
    },
  ]
})


import store from '../store';
router.beforeEach((to, from, next) => {
  const userInfo = localStorage.getItem('user')
  if (userInfo) {
    let user = JSON.parse(userInfo);
    let date = new Date();
    let now = (Math.floor(date.getTime() / 1000));
    if (now > user.expired_at) {
      store.dispatch('logout');
    }
  }
  next();
})

export default router;