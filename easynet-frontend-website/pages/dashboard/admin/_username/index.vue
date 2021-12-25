<template>
  <div v-if="auth.token">
    
    <HomeContent :userdata="userdata" :userlogins="userlogins" :messagecount="messagecount"/>

  </div>
</template>




<script>
import HomeContent from '@/components/Dashboard/Admin/home'

export default {
  layout: "dashboard",
  name: "admin",
  head:{
    titleTemplate: 'EasyNet - Admin'
  },

  data(){
    return {
      params: this.$route.path,
      userlogins:[],
      messagecount: ''
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
    this.dataUser(),
    this.UserLogin()
  },
  methods: {
    notification(){
      window.Echo.channel('notification')
      .listen('NotificationEvent', (e) => {
        this.notifdata=e[0]
        // console.log(e)
        this.UserLogin()
        this.$toast(e[0])
      })
    },

    UserLogin(){
      const config = {
        baseurl: process.env.BASEURL,
        token:  process.env.APITOKEN
      }
      this.$axios.get(`${config.baseurl}/count-online/${config.token}`)
      .then(res => {
        this.messagecount = res.data.message 
        this.userlogins = res.data.data
      })
      .catch(err => {
        console.log(err.response)
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
