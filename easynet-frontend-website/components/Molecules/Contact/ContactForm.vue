<template>
	<div>

		<!-- <pre>
			{{validation}}
		</pre> -->

		<form @submit.prevent="SendingMessage" class="form">
			<div class="row">

				<div v-if="error" class="col-lg-12 col-12 mb-3">
					<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Ooops!</strong> Periksa kembali kolom input dengan lengkap / benar
					</div>
				</div>

				<div v-if="success" class="col-lg-12 col-12 mb-3">
					<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Hallo! {{datasuccess.fullname}}</strong> kami akan segera merespon email anda {{datasuccess.email}}
					</div>
				</div>

				<input type="hidden" name="ip" v-model="field.ip">
				<input type="hidden" name="city" v-model="field.city">
				<input type="hidden" name="province" v-model="field.province">
				<br>
				<div class="col-lg-12 col-12">
					<div class="form-group">
						<label class="text-danger" for="category">Category</label>
						<select id="category" name="contact_categories[]" class="form-select" aria-label="Default select example">
							<option v-for="(item, index) in categories" :value="item.id" :key="index">
								{{item.category_contact_name}}
							</option>
						</select>
					</div>
				</div>
				<div class="col-lg-6 col-12">
					<div class="form-group">
						<input @mousedown="ResetForm" name="fullname" type="text" placeholder="Your Name" v-model="field.fullname">

						<div v-if="validation.fullname" class="alert alert-danger mt-2 mb-2 text-capitalize fw-bolder">
							{{validation.fullname[0]}}
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-12">
					<div class="form-group">
						<input @mousedown="ResetForm" name="email" type="text" placeholder="Your Email" v-model="field.email">

						<div v-if="validation.email" class="alert alert-danger mt-2 mb-2 text-capitalize fw-bolder">
							{{validation.email[0]}}
						</div>
					</div>
				</div>
				<div class="col-lg-12 col-12">
					<div class="form-group">
						<!-- <input @mousedown="ResetForm" name="phone" type="text" placeholder="format: 0811-xxx-12xx" v-model="field.phone"> -->
						<client-only>
							<vue-tel-input
							v-model="field.phone"
							></vue-tel-input>
						</client-only>
						<div v-if="validation.phone" class="alert alert-danger mt-2 mb-2 text-capitalize fw-bolder">
							{{validation.phone[0]}}
						</div>
					</div>
				</div>

				<div class="col-12">
					<div class="form-group message">
						<textarea @mousedown="ResetForm" name="address" placeholder="Your Address (*optional)" v-model="field.address"></textarea>

						<div v-if="validation.address" class="alert alert-danger mt-2 mb-2 text-capitalize fw-bolder">
							{{validation.address[0]}}
						</div>
					</div>
				</div>

				<div class="col-12">
					<div class="form-group message">
						<!-- <textarea name="message" placeholder="Your Message"></textarea> -->
						<client-only>
							<tinymce @mousedown="ResetForm" name="message" id="d1" v-model="field.message" :other_options="options"></tinymce>

							<div v-if="validation.message" class="alert alert-danger mt-2 mb-2 text-capitalize fw-bolder">
								{{validation.message[0]}}
							</div>
						</client-only>
					</div>
				</div>
				<div class="col-12">
					<div class="form-group button">
						<div class="d-grid gap-2">
							<button type="submit" class="btn ">
								<div v-if="loading">
									<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
									Loading...
								</div>
								<div v-else>
									Submit Message
								</div>
							</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</template>

<script>
	export default{
		data(){
			return {
				loading: null,
				error: null,
				success: false,
				categories: [],
				field:{},
				validation: {},
				options:{
					menubar:false
				},
				datasuccess:{}
			}
		},

		mounted(){
			this.ContactCategories(),
			this.$axios.get('https://api.ipify.org/?format=json')
			.then((data) => {
				this.field.ip = data.data.ip
				this.Locator(this.field.ip)
			}).catch(err => console.log(err.response))
		},
		methods:{
			ResetForm(){
				this.error=null
				this.validation=''
				this.success=false
			},
			ContactCategories(){
				this.$axios.get(`${process.env.BASEURL}/contact-categories/${process.env.APITOKEN}`)
				.then((data) => {
					this.categories = data.data.data
				})
				.catch(err => {
					console.log(err.message)
				})
			},

			Locator(ip){
				this.$axios.get(`${process.env.BASEURL}/locator/${ip}/${process.env.APITOKEN}`)
				.then((data) => {
					this.field.city = data.data.data.city
					this.field.province = data.data.data.region
				})
				.catch(err => {
					console.log(err.message)
				})
			},

			SendingMessage(){
				this.loading=true
				let category_id=document.querySelector(".form-select").value
				this.$axios.post(`${process.env.BASEURL}/send-message/${process.env.APITOKEN}`, {
					fullname: this.field.fullname,
					email: this.field.email,
					phone: this.field.phone,
					message: this.field.message,
					address: this.field.address,
					ip: this.field.ip,
					city: this.field.city,
					province: this.field.province,
					contact_categories: category_id
				})
				.then((data) => {
					console.log(data)
					if(data.data.success){
						this.success=true
						this.error=false
						this.loading=false
						this.$swal({
							position: 'top-end',
							icon: 'success',
							title: `Halo ! ${data.data.data.fullname} terima kasih kami akan merespon email anda ${data.data.data.email} secepatnya`,
							showConfirmButton: false,
							timer: 3000
						})
						this.datasuccess=data.data.data
						this.field={}
					}
				})
				.catch(err => {
					console.log(err.response.data)
					this.loading=false
					this.error=true
					this.$swal({
						icon: 'error',
						title: 'Oops...',
						text: 'Something went wrong!'
					})
					this.validation = err.response.data
					
				})
			}
		}
	}
</script>