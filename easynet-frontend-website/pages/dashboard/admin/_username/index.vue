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
      messagecount: '',
      allnotifs:[]
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
    this.AllNotification(),
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
        this.NotifLatest()
        this.$toast(e[0].message)
        // if(e[0].name === "login"){
          
        // }
        
      })
    },

    UserLogin(){
      const config = {
        baseurl: process.env.BASEURL,
        token:  process.env.APITOKEN
      }
      this.$axios.get(`${config.baseurl}/count-online/${config.token}`)
      .then(res => {
        this.messagecount = "User Online"
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
    },

    NotifLatest(){
      const config = {
        baseurl: process.env.BASEURL 
      }
      this.$axios.defaults.headers.common.Authorization = `Bearer ${this.auth.token}`;
      this.$axios.get(`${config.baseurl}/notification`)
      .then(res => {
        this.latests = res.data.data[0]
      })
      .catch(err => {
        console.log(err.message)
      })
    },

    AllNotification(){
      const config = {
        baseurl: process.env.BASEURL 
      }
      this.$axios.defaults.headers.common.Authorization = `Bearer ${this.auth.token}`;
      this.$axios.get(`${config.baseurl}/all-notifs`)
      .then(res => {
        this.allnotifs.show = true
        this.allnotifs.data = res.data.data.data
      })
      .catch(err => {
        console.log(err.message)
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
};
</script>
