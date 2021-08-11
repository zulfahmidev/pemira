<template>
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">KIP-PNL</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Tables -->
        <li class="nav-item">
            <router-link class="nav-link" :to="{name:'Voters', params: []}">
                <i class="fas fa-fw fa-users"></i>
                <span>Pemilih</span>
            </router-link>
        </li>

        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <router-link class="nav-link" :to="{name:'Cadidate Dpm', params: []}">
                <i class="fas fa-fw fa-user-tie"></i>
                <span>Kandidat DPM</span>
            </router-link>
        </li>
        
        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <router-link class="nav-link" :to="{name:'Cadidate Bem', params: []}">
                <i class="fas fa-fw fa-user-tie"></i>
                <span>Kandidat BEM</span>
            </router-link>
        </li>

        <!-- Nav Item - Tables -->
        <li class="nav-item">
            <router-link class="nav-link" :to="{name:'Settings', params: []}">
                <i class="fas fa-fw fa-cog"></i>
                <span>Pengaturan</span>
            </router-link>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Nav Item - Tables -->
        <li class="nav-item">
            <span class="nav-link" @click="logout" style="cursor: pointer;" href="tables.html">
                <i class="fas fa-fw fa-sign-out-alt"></i>
                <span>Keluar</span>
            </span>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/">
                <i class="fas fa-fw fa-home"></i>
                <span>Beranda</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->
</template>

<script>
export default {
    methods: {
        logout() {
            this.$store.dispatch('logout');
        }
    }
}
</script>