<template>
	<div>
		<div v-if="auth.token">
			<div class="row">
				<div class="col-lg-12 mb-4">
					<div class="card bg-light-100 border-0 shadow">
						<h1>Mikrotik Routeros</h1>
						
						<div v-if="router_ready" class="row justify-content-center">
							<RouterReady :router_ready="router_ready" :message="router_ready_message"/>
						</div>

						<div v-else class="row justify-content-center mb-5">
							
							<FromConnect :mikrotik="mikrotik" :ConnectRouter="ConnectRouter" :loading="loading" :success="success" :message="message" :not_found="not_found"/>
						</div>
					</div>
				</div>
			</div>
			<div v-if="router_ready" class="row">
				<div class="col-lg-12 mb-4">
					<div class="card bg-light-100 border-0 shadow">
						<div class="row justify-content-cente">
							<ManagementRouter/>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import RouterReady from '@/components/Dashboard/Admin/Mikrotik/router_ready'
	import FromConnect from '@/components/Dashboard/Admin/Mikrotik/form_connect'
	import ManagementRouter from '@/components/Dashboard/Admin/Mikrotik/management_router'

	export default{
		layout: 'dashboard',
		name: 'mikrotik',
		components: {
			RouterReady,
			FromConnect,
			ManagementRouter
		},
		data(){
			return {
				mikrotik: {},
				loading: null,
				routers: {},
				routeros: {},
				not_found: '',
				message:'',
				success: '',
				show: false,
				loading_storage: null,
				router_storage:{},
				router_ready:{},
				router_ready_message: ''
			}
		},

		beforeMount(){
			this.CheckingRouter()
		},

		methods: {
			checkAuth() {
				this.$store.commit("auths/CHECK_AUTH", "checked")
			},
			dataUser() {
				this.$store.dispatch("auths/storeUser", process.env.BASEURL)
			},

			CheckingRouter(){
				this.loading_storage=true
				const routers = localStorage.getItem("routeros") ? JSON.parse(localStorage.getItem('routeros')) : ''
				routers.map(d => {
					this.router_storage.identity = d.identity
					this.router_storage.ip = d.ip
				})
				this.$axios.defaults.headers.common.Authorization = `Bearer ${this.auth.token}`
				this.$axios.post(`${process.env.BASEURL}/check-router`,{
					ip: this.router_storage.ip
				})
				.then(res => {
					console.log(res.data)
					if(res.data.success){
						this.loading_storage=false
						this.router_ready=res.data.data
						this.router_ready_message=res.data.message
					}
				})
			},

			ConnectRouter(){
				this.loading=true
				this.$axios.defaults.headers.common.Authorization = `Bearer ${this.auth.token}`
				this.$axios.post(`${process.env.BASEURL}/connect-routeros`, {
					ip: this.mikrotik.ip,
					user: this.mikrotik.user,
					password: this.mikrotik.password
				})
				.then(res => {
					// console.log(res.data)
					this.mikrotik = ''
					if(res.data.success){
						this.show=true
						this.success=true
						this.loading=false
						this.message=res.data.message
						this.routeros=res.data.data
						localStorage.setItem("routeros", JSON.stringify(this.routeros))
					}else{
						this.show=true
						this.success=false
						this.loading=false
						this.not_found=res.data.message
					}
				})
				.catch(err => {
					this.loading=false
					console.log(err.message)
				})
			}
		},

		computed: {
			auth() {
				return this.$store.getters["auths/getAuth"];
			},
			userdata() {
				return this.$store.getters["auths/getUser"];
			}
		}
	}
</script>