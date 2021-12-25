<template>
	<div>
		<div v-if="loading" class="d-flex justify-content-center">
			<div class="col-lg-12 col-xs-12 col-sm-12">
				<center>
					<div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
						<span class="visually-hidden">Loading...</span>
					</div>
				</center>
			</div>
		</div>
		<div v-else>
			<form @submit.prevent="EditUser">
				<div class="mb-3">
					<label for="exampleInputEmail1" class="form-label">Email address</label>
					<input type="text" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" disabled="true" v-model="user.email">
				</div>
				<div class="mb-3">
					<label for="name" class="form-label">Fullname</label>
					<input type="text" name="name" class="form-control" id="name"  v-model="user.name">
				</div>
				<div class="mb-3">
					<label for="username" class="form-label">Username</label>
					<input type="text" name="username" class="form-control" id="username"  v-model="user.username">
				</div>
				<div class="mb-3">
					<label for="phone" class="form-label">Phone</label>
					<vue-tel-input 
	                  v-model="user.phone"
	                  id="phone"
	                  name="phone"
	                ></vue-tel-input>
				</div>
				<div class="mb-3">
					<label for="status" class="form-label">Status</label>
					<select @change="UserStatus($event)" name="status" id="status" class="form-select" aria-label="Default select example">
						<option selected v-model="user.status">
							{{user.status}}
						</option>
						<option value="">Change Status</option>
						<option value="INACTIVE" data-nama="INACTIVE">INACTIVE</option>
					</select>
				</div>
				<div class="mb-3">
					<label for="province" class="form-label">Province</label>
					<select @change="getCity($event)" name="province" id="province" class="form-select" aria-label="Default select example">
						<option selected v-model="user.province">
							{{user.province}}
						</option>
						<option value="">Change Province</option>
						<option v-for="(item,index) in provinces" :value="item.id" :data-nama="item.nama">
							{{item.nama}}
						</option>
					</select>
				</div>
				<div class="mb-3">
					<label for="city" class="form-label">City</label>
					<select @change="changeCity($event)" id="city" name="city" class="form-select" aria-label="Default select example">
						<option selected v-model="user.city">
							<span v-if="loading_city">
								<div class="spinner-grow text-primary" role="status">
									<span class="visually-hidden">Loading...</span>
								</div>
							</span>
							<span v-else>
								{{user.city}}
							</span>
						</option>
						<option v-if="!change" value="">Change City (*pilih province terlebih dahulu)</option>
						<option v-else value="">Change City</option>
						<option v-for="(item,index) in citys" :value="item.id" :data-nama="item.nama">
							{{item.nama}}
						</option>
					</select>
				</div>
				
				<div class="d-grid gap-2 mt-5 mb-2">
					<button type="submit" class="btn btn-primary rounded-pill">Submit</button>
				</div>
				<div class="d-grid gap-2 mt-5">
					<button @click="RefreshForm" type="submit" class="btn btn-info rounded-pill">Reset Form</button>
				</div>

			</form>
		</div>
	</div>
</template>

<script>
	export default {
		props: ['id'],
		data(){
			return {
				loading: null,
				change: null,
				change_status: null,
				change_city: null,
				change_province: null,
				provinces: [],
				citys:[],
				user:{},
				profile: {},
				product:{},
				package:{},
				loading_city: null,
				field: {}
			}
		},
		mounted(){
			this.UserDetail(this.$route.params.id),
			this.getProvinsi()
		},
		methods: {
			RefreshForm(){
				location.reload()
			},
			UserDetail(id){
				this.loading = true
				const config = {
					baseurl: process.env.BASEURL
				}
				this.$axios.get(`${config.baseurl}/user-manage/${id}`)
				.then((res) => {
					this.loading = false
					this.user = res.data.data
					this.profile = res.data.data.profiles[0]
					this.product = res.data.data.products[0]
					this.package = res.data.data.packages[0]
				})
				.catch(err => {
					console.log(err.message)
				})
			},
			EditUser(e){
				e.preventDefault()
				const datauser = {
					name: this.user.name,
					email: this.user.email,
					phone: this.user.phone,
					status: this.change_status ? this.field.status : this.user.status,
					city: this.change_city ? this.field.city : this.user.city,
					province: this.change_province ? this.field.province : this.user.province
				}

				console.log(datauser)
			},
			getProvinsi(){
				this.$axios.get('https://dev.farizdotid.com/api/daerahindonesia/provinsi')
				.then(res => {
					this.provinces = res.data.provinsi
				})
				.catch(err => console.log(err.response))
			},

			getCity(e){
				this.loading_city=true
				this.change_province=true
				const id = e.target.value
				const options = e.target.options
				this.field.province = options[options.selectedIndex].getAttribute('data-nama')
				this.$axios.get(`https://dev.farizdotid.com/api/daerahindonesia/kota?id_provinsi=${id}`)
				.then(res => {
					this.change = true
					this.loading_city=false
					this.citys = res.data.kota_kabupaten
				})
			},

			changeCity(e){
				this.change_city = true
				const options = e.target.options
				this.field.city = options[options.selectedIndex].getAttribute('data-nama')
			},

			UserStatus(e){
				this.change_status = true
				const options = e.target.options
				this.field.status = options[options.selectedIndex].getAttribute('data-nama')
			}

		}
	}
</script>