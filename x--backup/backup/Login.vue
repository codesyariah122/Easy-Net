<template>
	<div>
		<div class="mt-5 h-screen bg-white relative flex flex-col space-y-10 justify-center items-center">
			<div class="bg-white md:shadow-lg shadow-none rounded p-6 w-96" >
				<h1 class="text-3xl font-bold leading-normal" >Sign in</h1>
				<p class="text-sm leading-normal">Login EasyNet</p>

				<div v-if="error_login">
					<div class="p-5 rounded-lg border border-red-400 bg-red-300 text-red-900" role="alert">
						<p class="font-bold text-orange-900">User not found</p>
						<p>{{data_error_login}}</p>
					</div>
				</div>

				<div v-if="loginFailed" >				
					<div class="p-5 rounded-lg border border-yellow-400 bg-yellow-300 text-orange-900" role="alert">
						<p class="font-bold text-red-700">Login Failed</p>
						<p>{{failed}}</p>
					</div>
				</div>

				<form @submit.prevent="login" class="space-y-5 mt-5">
					<div class="mb-4 relative">
						<input id="email" class="w-full rounded px-3 border border-gray-500 pt-5 pb-2 focus:outline-none input active:outline-none" type="text" autofocus v-model="user.email">
						<label for="email" class="label absolute mb-2 -mt-2 pt-4 pl-3 leading-tighter text-gray-500 text-base mt-2 cursor-text">Email or Phone</label>
						<div class="text-red-700" v-if="validation.email">
							{{validation.email[0]}}
						</div>
					</div>
					<div class="mb-4 relative">
						<input id="password" class="w-full rounded px-3 border border-gray-500 pt-5 pb-2 focus:outline-none input active:outline-none" type="password" v-model="user.password"/>
						<label for="password" class="label absolute mb-0 -mt-2 pt-4 pl-3 leading-tighter text-gray-500 text-base mt-2 cursor-text">Password</label>
						<!-- <a class="text-sm font-bold text-blue-700 hover:bg-blue-100 rounded-full px-2 py-1 mr-1 leading-normal cursor-pointer">show</a> -->
						<div class="mt-2 text-red-700" v-if="validation.password">
							{{validation.password[0]}}
						</div>
					</div>
					<div class="-m-2">
						<a class="font-bold text-blue-700 hover:bg-blue-200 hover:underline hover:p-5 p-2 rounded-full" href="#">Forgot password?</a>
					</div>
					<button class="w-full text-center bg-blue-700 hover:bg-blue-900 rounded-full text-white py-3 font-medium" type="submit">
						<div v-if="loading">
							<div class="flex justify-center">
								<img src="https://i.pinimg.com/originals/76/8b/22/768b228e0d0ea7cf343e1dedfb4ddd6e.gif" alt="" width="50">
							</div>				
						</div>
						<div v-else>
							Sign in
						</div>
					</button>
				</form>
			</div>
			<p>New to EasyNet access?<a class="text-blue-700 font-bold hover:bg-blue-200 hover:underline hover:p-5 p-2 rounded-full" href="#">Join now</a></p>
		</div>
	</div>
</template>

<script>
	export default{
		layout: 'auth',
		data(){
			return {
				user: {
					email: '',
					password: ''
				},
				validation: {},
				loginFailed: null,
				failed: {},
				error_login: null,
				data_error_login: {},
				loading: null,
				checked: {}
			}
		},
		
		methods: {
			login(){
				this.loading = true
				const user = {
					email: this.user.email,
					password: this.user.password
				}
				this.$axios.post(`${process.env.BASEURL}/login`, {
					email: user.email,
					password: user.password
				})
				.then(res => {
					console.log(res)
					if(res.data.error_login){
						this.loading = false
						this.error_login = true
						this.data_error_login = res.data.err_message
					}else{			
						if(res.data.success){
							console.log(res.data)
							this.loading = false
							this.error_login = false
							this.loginFailed = false
							this.checked = {
								token: res.data.token,
								username: res.data.data.username,
								roles: res.data.data.roles.includes('ADMIN') ? 'ADMIN' : res.data.data.roles.includes('MEMBER') ? 'MEMBER' : 'STAFF'
							}
							localStorage.setItem('checked', JSON.stringify(this.checked))

							if(this.checked.roles === "ADMIN"){
								this.$router.push({
									path: '/dashboard/admin'
								})
							}else if(this.checked.roles === "MEMBER"){
								this.$router.push({
									path: '/dashboard/Member'
								})
							}else{
								this.$router.push({
									path: '/dashboard/Staff'
								})
							}

						}else{
							console.log(res)
							this.loading = false
							this.loginFailed = true
							this.error_login = false
							this.failed = res.data.message
						}
					}
				})
				.catch(err => {
					console.log(err.response)
					this.loading = false
					this.validation = err.response.data
				})
			}	
		}
	}
</script>

<style>
	* {
		margin:0;
		padding:0;
	}
	.input {
		transition: border 0.2s ease-in-out;
		min-width: 280px
	}
	.input:focus+.label,
	.input:active+.label,
	.input.filled+.label {
		font-size: .75rem;
		transition: all 0.2s ease-out;
		top: -0.3rem;
		color: #6b7280;
	}
	.label {
		transition: all 0.2s ease-out;
		top: 0.4rem;
		left: 0;
	}
</style>