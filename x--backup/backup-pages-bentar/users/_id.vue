<template>
	<div>
		<!-- <pre>
			{{profile}}
		</pre> -->
		<div v-if="loading" class="d-flex justify-content-center">
			<div class="col-lg-12 col-xs-12 col-sm-12">
				<center>
					<div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
						<span class="visually-hidden">Loading...</span>
					</div>
				</center>
			</div>
		</div>
		<div v-else class="row justify-content-center">
			<div class="col-lg-12 col-xs-12 col-sm-12">
				<h3>Detail User</h3>
			</div>
			<div class="col-lg-12 col-xs-12 col-sm-12">
				<div class="card">
					<div class="card-body">
						<ul class="list-group">
							<li class="list-group-item">
								Name : {{user.name}}
							</li>
							<li class="list-group-item">
								Email : {{user.email}}
							</li>
							<li class="list-group-item">
								Roles : {{(user.roles == "[\"ADMIN\"]") ? 'Admin' : (user.roles == "[\"STAFF\"]") ? 'Staff' : 'Customer'}}
							</li>
							<li class="list-group-item">
								Username : {{user.username}}
							</li>
              <li class="list-group-item">
                Status : {{user.status}}
              </li>
							<li v-if="profile" class="list-group-item">
								Address : {{profile.address}} | {{profile.post_code}}
							</li>
							<li v-else class="list-group-item">
								-
							</li>
							<li class="list-group-item">
								Location : {{user.city}} - {{user.province}}
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</template>

<script>
  export default {
    layout: "dashboard",
    head:{
      titleTemplate: 'EasyNet - Admin | User::Settings'
    },
    data(){
      return {
        loading: null,
        params: this.$route.path,
        user:{},
        profile: {}
      }
    },

    beforeMount(){
      this.checkAuth()
    },
    mounted() {
      this.registered(),
      this.checkToken(this.auth.token),
      this.dataUser(),
      this.UserDetail(this.$route.params.id)
    },
    methods: {
      UserDetail(id){
        this.loading = true
        const config = {
          baseurl: process.env.BASEURL
        }
        this.$axios.defaults.headers.common.Authorization = `Bearer ${this.auth.token}`
        this.$axios.get(`${config.baseurl}/user-manage/${id}`)
        .then((res) => {
          this.loading = false
          this.user = res.data.data
          this.profile = res.data.data.profiles[0]
        })
        .catch(err => {
          console.log(err.message)
        })
      },

      registered(){
        window.Echo.channel('registered')
        .listen('RegisterUserEvent', (e) => {
          this.notifdata=e[0]
          console.log(e)
          this.$toast(e[0])
        })
      },

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
              id: this.auth.id
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