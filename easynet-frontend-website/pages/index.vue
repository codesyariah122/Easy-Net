<template>
  <div>
    <!-- <ColorModePicker/> -->
    
    <SectionVideo/>

    <Features/>
    
    <Overview :location="location"/>

    <Packages :packages="data_packages"/>

    <News :blogs="blogs"/>

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


    async asyncData({$axios,$config,$content,params}){ 
      const token = process.env.APITOKEN
      const baseurl = process.env.BASEURL
      const data_packages = await $axios.$get(`${baseurl}/product/${token}`)
      const ip = await $axios.$get('https://api.ipify.org/?format=json')
      const location = await $axios.$get(`${baseurl}/locator/${ip.ip}/${token}`)
      const blogs = await $content('Blog', params.slug)
      .only(['title', 'description', 'img', 'slug', 'categories', 'createdAt', 'author'])
      .sortBy('createdAt', 'desc')
      .where({categories: 'blog'})
      .fetch();
      console.log(ip)
      console.log(location)
      return {
        data_packages,
        location,
        blogs
      }
    },

  }
</script>
