<template>
  <div>
    <div v-if="auth.token">
      
      <!-- <pre>
        {{userdata}}
      </pre>

      <pre>
        {{userdata.log_logins[0].id}}
      </pre> -->

      <Home :userdata="userdata" :auth="auth" :path="path" @logout="logout"/>
      
    </div>
  </div>
</template>

<script>
  import Home from '@/components/Customer/home'
  export default {
    layout: "profile",
    name: "profile",
    head:{
      titleTemplate: 'EasyNet - Customer'
    },
    components:{
      Home
    },
    data(){
      return {
        path: this.$route.path
      }
    },
    beforeMount(){
      $crisp.push(['do', 'chat:open']),
      this.checkAuth(),
      this.dataUser()
    },
    mounted() {
      this.checkToken(this.auth.token),
      this.checkAuth(),
      this.ChatOpen(this.userdata)
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
      ChatOpen(user){
        $crisp.push(["set", "user:email", user.email])
        $crisp.push(["set", "user:nickname", user.name])
        // $crisp.push(["set", "session:data", [
        //   [
        //   ["user_id", user.id],
        //   ["username", user.username],
        //   ["fullname", user.fullname],
        //   ["email", user.email]
        //   ]
        // ]])
        $crisp.push(['do', 'chat:open'])
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
  };
</script>
