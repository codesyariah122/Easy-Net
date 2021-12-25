<template>
  <div>
    <div v-if="auth.token">
      <HomeContent :userdata="userdata"/>
    </div>
  </div>
</template>

<script>
import HomeContent from '@/components/Dashboard/Sales/home'

export default {
  layout: "dashboard",
  name: "sales",
  components: {
    HomeContent
  },

  head:{
    titleTemplate: 'EasyNet - Support'
  },
  
  beforeMount(){
    if(!this.auth.token){
      this.$router.push({
        path: '/auth/login'
      })
    }
  },
  mounted() {
    this.checkAuth(),
    this.dataUser()
  },
  methods: {
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
};
</script>
