<template>
  <div>
    <!-- <ColorModePicker/> -->
    <SectionVideo :herodata='herodata'/>

    <Features/>
    
    <Overview :location="location"/>

    <Packages :packages="data_packages"/>

    <News/>

    <Contact/>
    
  </div>
</template>

<script>
  import SectionVideo from '@/components/HomePage/SectionVideo'
  import Features from '@/components/HomePage/Features'
  import Overview from '@/components/HomePage/Overview'
  import Packages from '@/components/HomePage/Packages'
  import News from '@/components/HomePage/News'
  import Contact from '@/components/HomePage/Contact'
  import ColorModePicker from '@/components/ColorModePicker'

  export default {
    layout: 'default',
    components:{
      SectionVideo,
      Features,
      Overview,
      Contact,
      Packages,
      News,
      ColorModePicker
    },
    data(){
      return {
        herodata: {},
        loading: null
      }
    },

    head:{
      titleTemplate: 'EasyNet::Official'
    },


    async asyncData({$axios,$config}){ 
      const token = process.env.APITOKEN
      const baseurl = process.env.BASEURL
      const data_packages = await $axios.$get(`${baseurl}/product/${token}`)
      const ip = await $axios.$get('https://api.ipify.org/?format=json')
      const location = await $axios.$get(`${baseurl}/locator/${ip.ip}/${token}`)

      return {
        data_packages,
        location
      }
    },

    mounted(){
      this.getHeroData()
      // window.Echo.channel('contacted')
      // .listen('ContactMessageEvent', (e) => {
      //   console.log(e)
      // })
    },

    methods: {
      getHeroData(){
        this.loading=true
        const data = {
          token:  process.env.APITOKEN,
          baseurl: process.env.BASEURL 
        }
        this.$axios.get(`${data.baseurl}/webdata/${data.token}`)
        .then(res => {
                // console.log(res.data.data)
                setTimeout(() => {
                  this.loading=false
                  this.herodata = res.data.data
                }, 2500)
            })
        .catch(err => {
          console.log(err.response)
        })
      },


    }
  }
</script>
