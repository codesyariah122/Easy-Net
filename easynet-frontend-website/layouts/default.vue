<template>
	<div>		
		<Header :auth="auth"/>

		<!-- <pre>
			{{userdata.roles}}
		</pre> -->

		<Hero :herodata="herodata" @open-chat="CheckUserChatDB" />

		<Nuxt/>

		<Footer />

		<a href="#" class="scroll-top btn-hover">
			<i class="lni lni-chevron-up"></i>
		</a>

		<!-- Modal -->
		<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="staticBackdropLabel">Open chat Support</h5>

						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="container">
							<div class="row justify-content-center">
								<div class="col-lg-12 col-xs-12 col-sm-12">
									<blockquote class="blockquote-footer bg-info text-danger">
										Masukan alamat email anda yang telah terdaftar pada website easynet.id.
									</blockquote>
									<p class="mt-2 mb-3">
										Belum punya akun easynet  ? <br> 

										<a href='/auth/register' class="btn btn-link">Create New Account </a>
									</p>
								</div>

							</div>
							<div class="row justify-content-center">
								<div class="col-lg-12 col-xs-12 col-sm-12">
									<form @submit.prevent="CheckEmail">
										<div class="form-group">
											<label for="email" class="form-label">Email address</label>
											<input type="text" class="form-control" id="email" placeholder="name@example.com" v-model="user.email" autofocus>
											<div v-if="error">
												<div v-if="validation" class="alert alert-danger mt-2 mb-2">
													{{validation.email[0]}}
												</div>
											</div>
											<div v-else>
												<div v-if="message.ready" class="alert alert-warning mt-3" role="alert">
													{{
														message.ready
													}}
													<br>
													<button type="button" class="btn btn-primary rounded-pill mt-2" @click="RefreshPage">Refresh Halaman</button>
												</div>
												<div v-else>
													<div v-if="notFound" class="alert alert-danger mt-2 mb-2">
														<!-- {{notFound}} -->
														<p class="mt-2">
															{{message.not_found}}<br> 

															<!-- <a href='/auth/register' class="btn btn-link">Create New Account </a> -->
														</p>
													</div>

													<div v-if="dataFound" class="alert alert-success mt-3" role="alert">
														{{
															dataFound
														}}
														<br>
														<button type="button" class="btn btn-primary rounded-pill mt-2" @click="RefreshPage">Refresh Halaman</button>
													</div>
												</div>

														<!-- <pre v-if='data_user'>
															{{data_user}}
														</pre> -->
													</div>
												</div>
												<div class="d-grid gap-2 mt-5">
													<button type="submit" class="btn btn-primary rounded-pill btn-block">
														<div v-if="loadingForm">
															<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
															Loading...
														</div>
														<div v-else>
															Submit
														</div>
													</button>
												</div>
												<div class="modal-footer">
													
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
		</div>
	</template>

	<script>
		import Header from '@/components/Layouts/Header'
		import Hero from '@/components/Layouts/partials/Hero'
		import Footer from '@/components/Layouts/Footer'

		export default{
			components: {
				Header,
				Hero,
				Footer
			},

			head:{
				link: [
					{ rel: 'stylesheet', type: 'text/css', href: '/assets/css/main.css'},
					{ rel: 'stylesheet', type: 'text/css', href: '/assets/css/new-style.css'}
				],

				script: [
					{
						src: '/assets/js/main.js',
						type: 'text/javascript'
					},
					{
						src: 'https://widget.tochat.be/bundle.js?key=89ae7aff-d3ec-425e-ad9e-a4049e3f5796',
						defer: true
					}
				]
			},
			
			data(){
				return {
					config: {
						apiUrl: process.env.BASEURL,
						apiToken: process.env.APITOKEN
					},
					loadingForm: null,
					herodata: {},
					loading: null,
					user:{},
					validation: {},
					error: null,
					success: null,
					dataFound: '',
					notFound:null,
					message:{
						not_found: '',
						ready: ''
					},
					data_user: '',
					chat: localStorage.getItem('chat_aktif') ? $crisp.push(['do', 'chat:open']) : $crisp.push(['do', 'chat:hide']),
					chek_user_chat: null,
					readys: []
				}
			},
			beforeMount(){
				this.getHeroData(),
				this.checkAuth(),
				this.dataUser()
			},

			methods: {
			
			getHeroData(){
				this.herodata = {
					headerText: `Nikmati Layanan Internet <span class='text-warning'>High Performance </span><span class='text-info text-justify'>Unlimited Bandwidth</span> Bersama <span class='text-info fw-bold'>Easy Net</span>`,
					headerParagraph: `Melalui infrastruktur High Performance internet kami. Kami siap memenuhi kebutuhan aktifitas anda mulai dari aktifitas Multimedia, Mailing, Study, Streaming hingga , Gaming`
				}
				
			},

			checkAuth() {
				this.$store.commit("auths/CHECK_AUTH", "checked")
			},
			dataUser() {
				this.$store.dispatch("auths/storeUser", process.env.BASEURL)
			},

			CheckUserChatDB(){
				
				const data_user = JSON.parse(localStorage.getItem('data_chat')) ? JSON.parse(localStorage.getItem('data_chat')) :  0
				if(data_user == 0){
					this.OpenChat(data_user)
				}
				this.$axios.get(`${this.config.apiUrl}/active-user-chat/${this.config.apiToken}/${data_user.id}`)
				.then(response => {
					this.OpenChat(response.data.data.chats)
				})
				.catch(error => {
					console.log(error.message)
				})
			},

			OpenChat(status){

				if(status !== 0){
					$crisp.push(['do', 'chat:open'])
				}else{
					let myModal = new bootstrap.Modal(document.getElementById('staticBackdrop'),{ backdrop: 'static', keyboard: false })

					myModal.show()

					const close = document.querySelector('.btn-close')
					close.addEventListener('click', () => {
						myModal.hide()
						this.loadingForm=false
						this.error = false
						this.user.email = ''
						this.notFound=true
						this.validation=''
						this.message.not_found = ''
						this.success = ''
						this.notFound = ''
					})
				}

			},

			CheckEmail(e){
				this.loadingForm=true
				this.error = false
				e.preventDefault()
				const email = this.user.email
				
				this.$axios.post(`${this.config.apiUrl}/check-user-email/${this.config.apiToken}`, {
					email: email,
					chat_aktif: 1
				})
				.then(response => {
					// console.log(response.data.not_register)
					this.loadingForm=false
					this.error = false
					this.user.email = ''

					if(response.data.not_register  == true){
						this.error = false
						this.notFound=true
						this.validation=''
						this.$swal({
							icon: 'error',
							title: 'Oops...',
							text: response.data.message,
						})
						this.message.not_found = response.data.message
					}else{
						this.readys = response.data.data
						if(this.readys.length % 2 == 1){
							this.notFound=false
							this.message.ready = response.data.message
							const chat_data = {
								id: this.readys[0].user_id,
								username: this.readys[0].users[0].username,
								name: this.readys[0].users[0].name,
								email: this.readys[0].users[0].email 
							}
							this.SettingCrispChat(chat_data)
						}else{
							if(response.data.success){
								this.dataFound=response.data.message
								this.data_user=response.data

								const chat_data = {
									id: this.data_user.data.id,
									username: this.data_user.data.username,
									fullname: this.data_user.data.fullname,
									email: this.data_user.data.email 
								}

								this.SettingCrispChat(chat_data)

							}else{
								this.success = response.data.success
								this.notFound = response.data.message
							}
						}
					}
				})
				.catch(error => {
					this.loadingForm=false
					this.error = true
					this.$swal({
						icon: 'error',
						title: 'Oops...',
						text: 'Something went wrong!',
					})
					this.validation = error.response.data
				})
			},

			RefreshPage(){
				location.reload()
			},

			SettingCrispChat(chat_data){
				localStorage.setItem('chat_aktif', true)
				localStorage.setItem("data_chat", JSON.stringify(chat_data))
				$crisp.push(['do', 'chat:open'])
				$crisp.push(["set", "user:email", chat_data.email])
				$crisp.push(["set", "user:nickname", chat_data.name])
				// $crisp.push(["set", "session:data", [
				// 	[
				// 	["user_id", chat_data.id],
				// 	["username", chat_data.username],
				// 	["fullname", chat_data.name],
				// 	["email", chat_data.email]
				// 	]
				// ]])
				this.$swal({
					position: 'top-end',
					icon: 'success',
					title: `Halo ! ${chat_data.name}, silahkan memulai fitur live chat EasyNet`,
					showConfirmButton: false,
					timer: 1500
				})

				setTimeout(function(){
					let myModal = document.getElementById('staticBackdrop')
					myModal.style.visibility="hidden"
					document.body.classList.remove('modal-open')
					location.reload()
				},2500)
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
