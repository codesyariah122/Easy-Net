<template>
	<div v-if="auth.token">
    <div class="row">
      <div class="col-12 mb-4">
        <div class="card bg-light-100 border-0 shadow">

          <!-- <pre>
            {{userdata}}
          </pre> -->

          <div class="table-responsive py-4">
            <table class="table table-flush" id="datatable">
              <thead class="thead-light">
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Options</th>
                </tr>
              </thead>
              <tbody>
                <tr v-if="loading">
                  <td class="text-center text-info" colspan="4">
                    <div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
                      <span class="visually-hidden">Loading...</span>
                    </div>
                 </td>
                </tr>
                <tr v-else v-for="user in users.data">
                  <td style="text-transform: capitalize;"> {{user.name}} </td>
                  <td style="text-transform: lowercase;"> {{user.email}} </td>
                  <td>
                    <nuxt-link :to="`/dashboard/admin/${userdata.username}/users/${user.id}`" class="btn btn-success rounded-pill btn-sm">
                      <i class="lni lni-eye"></i>
                    </nuxt-link>

                    <nuxt-link v-if="!user.roles.includes('ADMIN')" :to="`/dashboard/admin/${userdata.username}/users/edit/${user.id}`" class="btn btn-info rounded-pill btn-sm">
                      <i class="lni lni-pencil-alt"></i>
                    </nuxt-link>

                    <button v-if="!user.roles.includes('ADMIN')" class="btn btn-danger rounded-pill btn-sm">
                      <i class="lni lni-eraser"></i>
                    </button>

                    <button @click.prevent="isLogin" v-else class="btn btn-danger rounded-pill btn-sm"><i class="lni lni-coffee-cup"></i></button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="card-body p-2">
            <div class="ct-chart-sales-value ct-double-octave ct-series-g">
              <div class="d-flex justify-content-center">
                <pagination :data="users" @pagination-change-page="UserList"></pagination>
              </div>
            </div>
          </div>
          <div class="card-body p-2">
            <div class="ct-chart-sales-value ct-double-octave ct-series-g">
             
            </div>
          </div>
        </div>
      </div>
     
      
    </div>
	</div>
</template>

<script>
  export default {
    layout: "dashboard",
    name: 'users',
    head:{
      titleTemplate: 'EasyNet - Admin | User::Settings'
    },
    data(){
      return {
        loading: null,
        params: this.$route.path,
        users:[]
      }
    },

    beforeMount(){
      this.checkAuth()
    },
    mounted() {
      this.notification(),
      this.checkToken(this.auth.token),
      this.dataUser(),
      this.UserList()
    },
    methods: {
      isLogin(){
        this.$swal({
          icon: 'error',
          title: 'Oops...',
          text: 'you are logged in',
        })
      },
      UserList(page = 1){
        this.loading = true
        const config = {
          baseurl: process.env.BASEURL
        }
        this.$axios.defaults.headers.common.Authorization = `Bearer ${this.auth.token}`
        this.$axios.get(`${config.baseurl}/user-manage?page=${page}`)
        .then((res) => {
          // console.log(res.data.data)
          this.loading = false
          this.users = res.data.data
        })
        .catch(err => {
          console.log(err.message)
        })
      },

      notification(){
        window.Echo.channel('notification')
        .listen('NotificationEvent', (e) => {
          this.UserList()
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