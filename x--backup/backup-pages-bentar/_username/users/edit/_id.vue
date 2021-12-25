<template>
	<div>
		<div class="row justify-content-center">
			<div class="col-lg-12 col-xs-12 col-sm-12">
				<h3>Edit User  <span v-if="loading">
          <div class="spinner-grow text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>    
        </span>
        <span v-else style="text-transform: capitalize;">
          {{user.name}}
        </span></h3>
			</div>
			<div class="col-lg-12 col-xs-12 col-sm-12">
				<div class="card">
					<div class="card-body">
            <FormEdit :id="$route.params.id"/>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</template>

<script>
  import FormEdit from '@/components/Dashboard/Admin/Molecules/FormEdit'

  export default {
    layout: "dashboard",
    components:{
      FormEdit
    },
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
      registered(){
        window.Echo.channel('registered')
        .listen('RegisterUserEvent', (e) => {
          this.notifdata=e[0]
          console.log(e)
          this.$toast(e[0])
        })
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