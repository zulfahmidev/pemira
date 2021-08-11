<template>
    <!-- Topbar -->
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

        <!-- Sidebar Toggle (Topbar) -->
        <form class="form-inline">
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>
        </form>

        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto">


            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link" href="#">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ user.name }}</span>
                    <div class="img-profile rounded-circle bg-light d-flex align-items-center justify-content-center"><i class="fa fa-user"></i></div>
                </a>
            </li>

        </ul>

    </nav>
    <!-- End of Topbar -->
</template>

<script>
export default {
    data() {
        return {
            user: {
                name: ''
            },
        }
    },
    mounted() {
        const userInfo = localStorage.getItem('user')
        if (!userInfo) {
            location.replace('/manager/login');
        }
        this.user = JSON.parse(userInfo);
    },
}
</script>