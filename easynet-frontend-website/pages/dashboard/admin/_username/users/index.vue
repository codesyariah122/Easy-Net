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
                  <th>Status</th>
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
                  <td style="text-transform: lowercase;">
                    <span v-if="user.status === 'INACTIVE'" class="badge bg-danger">
                      {{user.status}} 
                    </span>
                    <span v-else class="badge bg-success">
                      {{user.status}} 
                    </span>
                  </td>
                  <td>
                    <nuxt-link :to="`/dashboard/admin/${userdata.username}/users/${user.id}`" class="btn btn-success rounded-pill btn-sm">
                      <i class="lni lni-eye"></i>
                    </nuxt-link>

                    <nuxt-link v-if="!user.roles.includes('ADMIN')" :to="`/dashboard/admin/${userdata.username}/users/edit/${user.id}`" class="btn btn-info rounded-pill btn-sm">
                      <i class="lni lni-pencil-alt"></i>
                    </nuxt-link>

                    <button v-if="!user.roles.includes('ADMIN')" class="btn btn-danger rounded-pill btn-sm" @click.prevent="DeleteUser(user.id)">
                      <i class="lni lni-eraser"></i>
                    </button>

                    <button @click.prevent="isAdmin" v-else class="btn btn-danger rounded-pill btn-sm"><i class="lni lni-coffee-cup"></i></button>
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
      isAdmin(){
        this.$swal({
          icon: 'error',
          title: 'Oops...',
          text: 'this is admin role',
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

      DeleteUser(id){
        this.$swal({
          title: 'Are you sure?',
          text: "You won't be able to delete this user permanently.",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete!'
        }).then((result) => {
          if (result.isConfirmed) {
            console.log(id)
            // this.$axios.defaults.headers.common.Authorization = `Bearer ${this.auth.token}`
            this.$axios.delete(`${process.env.BASEURL}/user-manage/${id}`)
            .then(res => {
              console.log(res.data)
              if(res.data.success){
                this.UserList()
                this.$swal(
                  'Delete Success!',
                  res.data.message,
                  'success'
                )
              }
            })
            .catch(error => {
              console.log(error.message)
            })
          }
        })
      }
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