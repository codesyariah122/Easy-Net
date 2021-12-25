<template>
	<div>
		<Header/>
		<Sidebar :userdata="userdata" :logout="logout" :route="route"/>
		<main class="content">
			<NavMain :auth="auth" :userdata="userdata" :logout="logout"/>
			<Nuxt/>
		</main>
		<!-- <Footer/> -->
	</div>
</template>

<script>
	import Header from '@/components/Dashboard/Header'
	import Sidebar from '@/components/Dashboard/Sidebar'
	import NavMain from '@/components/Dashboard/Navbar'
	import Footer from '@/components/Dashboard/Footer'

	export default{
		name: 'dashboard',
		data(){
			return  {
				route: this.$route.path
			}
		},
		components: {
			Header,
			Sidebar,
			NavMain,
			Footer
		},
		head:{
			link: [
				{
					rel: 'stylesheet',
					href: '/assets/dashboard/vendor/notyf/notyf.min.css',
					type: 'text/css'
				},
				{
					rel: 'stylesheet',
					href: '/assets/dashboard/css/volt.css',
					type: 'text/css'
				}
			],
			script:[
				{
					src: '/assets/dashboard/js/volt.js',
					type: 'text/javascript'
				},
				{
					src: '/assets/vendor/simplebar/dist/simplebar.min.js'
				},
				{
					src: '/assets/vendor/notyf/notyf.min.js'
				},
				{
					src: '/assets/vendor/vanillajs-datepicker/dist/js/datepicker.min.js'
				},
				{
					src: '/assetshttps://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js'
				},
				{
					src: '/assets/vendor/vanillajs-datepicker/dist/js/datepicker.min.js'
				},
				{
					src: '/assets/vendor/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js'
				},
				{
					src: '/assets/vendor/chartist/dist/chartist.min.js'
				},
				{
					src: '/assets/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js'
				},
				{
					src:  '/assets/vendor/nouislider/distribute/nouislider.min.js'
				},
				{
					src: '/assets/vendor/onscreen/dist/on-screen.umd.min.js'
				}
			]
		},

		beforeMount(){
			this.checkAuth()
		},
		mounted(){
			$crisp.push(['do', 'chat:hide']),
			this.checkToken(this.auth.token),
			this.dataUser()
		},
		methods: {

			checkToken(token){
				if(!token){
					this.$swal({
						icon: 'error',
						title: 'Oops...',
						text: 'Kamu belum login !! Silahkan login ',
					})
					this.$router.push({
						path: '/auth/login'
					})
				}
			},
			checkAuth() {
				this.$store.commit("auths/CHECK_AUTH", "checked")
			},
			dataUser() {
				this.$store.dispatch("auths/storeUser", process.env.BASEURL)
			},

			logout() {
				this.$swal({
					title: 'Are you sure?',
					text: "You won't be able to logout this page.",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, logout!'
				}).then((result) => {
					if (result.isConfirmed) {
						this.$axios.defaults.headers.common.Authorization = `Bearer ${this.auth.token}`
						this.$axios.post(`${process.env.BASEURL}/logout`,{
							id: this.auth.id,
							log_id: this.userdata.log_logins[0].id
						})
						.then(response => {

							if(response.data.success) {
								this.$swal(
									'Logout Success!',
									`Bye ${this.userdata.username}`,
									'success'
								)
				                //remove localStorage
				                localStorage.removeItem('checked')

				                //redirect ke halaman login
				                return this.$router.push({
				                  	path: '/auth/login'
				                })
				            }

				        })
						.catch(error => {
							console.log(error.message)
						})

					}
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