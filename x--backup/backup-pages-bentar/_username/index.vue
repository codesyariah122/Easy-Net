<template>
  <div v-if="auth.token">
    
    <!-- <pre>
      {{userdata.log_logins[0].id}}
    </pre> -->

    <HomeContent :userdata="userdata" />

  </div>
</template>




<script>
import HomeContent from '@/components/Dashboard/Admin/home'

export default {
  layout: "dashboard",
  head:{
    titleTemplate: 'EasyNet - Admin'
  },

  data(){
    return {
      params: this.$route.path
    }
  },

  components: {
    HomeContent
  },

  beforeMount(){
    this.checkAuth()
  },
  mounted() {
    this.notification(),
    this.checkToken(this.auth.token),
    this.dataUser()
  },
  methods: {
    

    notification(){
      window.Echo.channel('notification')
      .listen('NotificationEvent', (e) => {
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
