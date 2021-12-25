<template>
	<div>
		<header class="header index2">
            <div id="navbar-scroll" class="navbar-area">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-12">
                            <nav class="navbar navbar-expand-lg">
                                <nuxt-link class="navbar-brand logo" to="/#home">
                                    <!-- <img class="logo1" src="assets/images/logo/logo-router.svg" alt="Logo" style="width:60px; margin-top: .5rem;"> -->
                                    <img class="logo1" src="assets/images/logo/logo-blue.svg">
                                    <img class="logo2" src="assets/images/logo/logo-blue.svg" alt="Logo">
                                </nuxt-link>
                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="toggler-icon"></span>
                                    <span class="toggler-icon"></span>
                                    <span class="toggler-icon"></span>
                                </button>

                                <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                                    <ul id="nav" class="navbar-nav mx-auto">
                                        <li class="nav-item">
                                            <a class="nav-link page-scroll" href="#features">Features</a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link page-scroll" href="#overview">Overview</a> </li>
                                        <li class="nav-item"><a class="nav-link page-scroll" href="#packages">Packages</a></li>
                                        <!-- <li class="nav-item"><a href="#team">team</a></li> -->
                                        <li class="nav-item"><a class="nav-link page-scroll" href="#blog">Blog</a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link page-scroll" href="#contact">Contact</a></li>
                                    </ul>
                                </div>

                                <div class="button">
                                    <div v-if="auth.token">
                                        <div class="dropdown">
                                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                {{userdata.username}}
                                            </a>

                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <li><nuxt-link v-if="userdata.roles.includes('CUSTOMER')" class="dropdown-item" to="#"><i class="lni lni-cart"></i>Cart</nuxt-link></li>
                                                <li>
                                                    <a v-if="userdata.roles.includes('CUSTOMER')" class="dropdown-item" :href="`/profile/customer/${userdata.username}`">
                                                        <i class="lni lni-user"></i>
                                                        Profile
                                                    </a>
                                                    <nuxt-link v-else-if="userdata.roles.includes('ADMIN')" class="dropdown-item" :to="`/dashboard/admin/${userdata.username}`">
                                                        <i class="lni lni-dashboard"></i>
                                                        Dashboard
                                                    </nuxt-link>
                                                    <nuxt-link v-else-if="userdata.roles.includes('SALES')" class="dropdown-item" to="/dashboard/sales">
                                                        <i class="lni lni-dashboard"></i>
                                                        Dashboard
                                                    </nuxt-link>
                                                    <nuxt-link v-else class="dropdown-item" to="/dashboard/support">
                                                        <i class="lni lni-dashboard"></i>
                                                        Dashboard
                                                    </nuxt-link>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <div class="dropdown">
                                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="lni lni-user"></i> profile
                                            </a>

                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <li><nuxt-link to="/auth/login" class="dropdown-item"><i class="lni lni-cart"></i>Cart</nuxt-link></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- <nuxt-link v-else to="/auth/login" :class="`btn btn-primary ${btn_auth}`">Get it now</nuxt-link> -->
                                    <!-- <nuxt-link to="/auth/Register" :class="`btn btn-primary ${btn_auth}`">Get it now</nuxt-link> -->
                                </div>
                            </nav>

                        </div>
                    </div>

                </div>

            </div>

            <!-- <pre>
                {{auth}}
            </pre> -->

        </header>
    </div>
</template>

<script>
    export default{

        data(){
            return{
                btn_auth: ''
            }
        },

        mounted(){
            this.NavbarToggler(),
            this.buttonAuth(),
            this.checkAuth(),
            this.dataUser()
        },
        
        methods: {
            checkAuth() {
              this.$store.commit("auths/CHECK_AUTH", "checked")
            },
            dataUser() {
              this.$store.dispatch("auths/storeUser", process.env.BASEURL)
            },
            buttonAuth(){
                this.btn_auth = this.$device.isMobile ? 'btn-auth' : ''
            },
            NavbarToggler(){
				 // header-2  toggler-icon
                let navbarToggler2 = document.querySelector(".header .navbar-toggler");
                var navbarCollapse2 = document.querySelector(".header .navbar-collapse");

                document.querySelectorAll(".header-2 .page-scroll").forEach(e =>
                  e.addEventListener("click", () => {
                     navbarToggler2.classList.remove("active");
                     navbarCollapse2.classList.remove('show')
                 })
                  );
                navbarToggler2.addEventListener('click', function() {
                  navbarToggler2.classList.toggle("active");
              })
            },
        },

        computed: {
            auth() {
              return this.$store.getters["auths/getAuth"];
            },
            userdata() {
              return this.$store.getters["auths/getUser"];
            },
        },
    }
</script>

<style>
    
    @media (min-width: 992px) {
        .navbar-collapse{
            margin-left: 7rem;
        }
    }
    .header .button .btn .btn-auth{
        width: 50px!important;
    }
</style>
