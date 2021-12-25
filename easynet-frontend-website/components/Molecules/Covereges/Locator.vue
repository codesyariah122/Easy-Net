<template>
  <div>
    <client-only>

        <l-map :style="`${isMobile ? 'height:350px; width: 100%;' : 'height:450px; width: 900px;'}`" :zoom="zoom" :center="center">
            <l-marker :lat-lng="server">
              <l-icon
              :icon-size="iconServer.iconSize"
              :icon-anchor="iconServer.staticAnchor"
              :icon-url="icons[2]"
              :shadow-url="icons[3]"
              />
              <l-popup>
                <center class="container">
                  <span class="font-weight-bold bd-highlight">
                    {{serverdata.title}}
                  </span><br>
                  <small class="text-success">
                    {{ serverdata.region }}
                  </small>
                  <br>
                  <img :src="icons[4]" width="75">
                  <br><br>
                  <a :href="serverdata.external_link" class="btn btn-primary btn-sm text-white rounded-pill">View Location</a>
                </center>
              </l-popup>
            </l-marker>

            <l-tile-layer :url="url" :attribution="attribution"></l-tile-layer>
            <l-layer-group ref="features">
              <l-popup > <span>  Your area {{caller}} its ready to connect easynet </span></l-popup>
            </l-layer-group>
            <l-marker :lat-lng="markerLatLng" @click="openPopUp(markerLatLng, 'marker')">
              <l-icon
              :icon-size="iconClient.iconSize"
              :icon-anchor="iconClient.staticAnchor"
              :icon-url="icons[1]"
              :shadow-url="icons[3]"
              />
              <l-popup>
                <center class="container">
                  <span class="font-weight-bold bd-highlight">
                   Your Location  : {{location.data.city}}  - {{ location.data.region }}
                 </span><br>
                 <br>
                 <img :src="icons[6]" width="75">
               </center>
             </l-popup>
           </l-marker>
           <l-circle
           :lat-lng="center"
           :radius="circle.radius"
           :color="circle.color"
           @click="openPopUp(circle.center, `${location.data.city}-${location.data.region}`)"
           />
           <l-polyline :lat-lngs="polyline.latlngs" :color="polyline.color" />
         </l-map>
    </client-only>
  </div>
</template>

<script>
export default {
  props: ['location'],
  data () {
    return {
      url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
      attribution:
        '&copy; <a target="_blank" href="http://osm.org/copyright">EasyNetMap</a> contributors',
      zoom: this.$device.isMobile ? 10 : 12,
      center: [this.location.data.latitude, this.location.data.longitude],
      markerLatLng: [this.location.data.latitude, this.location.data.longitude],
      isMobile: this.$device.isMobile,
      caller: null,
      circle: {
        // center: [-6.971627551665847,107.54649735137858],
        center:{
          lat: null,
          lng: null
        },
        radius: 32000,
        color: 'red'
      },
      icons: {
        1: require("assets/marker-custom/router1.png"),
        2: require("assets/marker-custom/tower.png"),
        3: require("assets/marker-custom/marker-shadow.png"),
        4: require("assets/marker-custom/tower-5.png"),
        5: require("assets/marker-custom/tower-3.png"),
        6: require("assets/marker-custom/home.png"),
        7: require("assets/marker-custom/server.png"),
        8: require('assets/marker-custom/building-icon-3.png')
      },
      iconServer: {
        staticAnchor: [10, 15],
        iconSize: [80, 80],
      },
      iconClient: {
        staticAnchor: [10, 15],
        iconSize: [50, 50],
      },
      coordinates: [],
      server: {
        lat: null,
        lng: null
      },
      office:{
        lat: null,
        lng: null
      },
      serverdata:{
        title: '',
        region: '',
        external_link:''
      },
      officedata:{
        title: '',
        region: '',
        external_link:''
      },
      polyline: {
        latlngs: [],
        color: 'green'
      }
    }
  },

  mounted(){
    this.Center()
  },

  methods: {
    openPopUp (latLng, caller) {
      this.caller = caller;
      this.$refs.features.mapObject.openPopup(latLng);
    },
    Center() {
      const config = {
        url: process.env.BASEURL,
        token: process.env.APITOKEN,
      };
      this.$axios
      .get(`${config.url}/coordinates/${config.token}`)
      .then((res) => {
        this.coordinates = res.data.data[1].maps
        let lines = res.data.data[0].maps
        this.coordinates.map(d => {
          // this.circle.center.push(Number(d.lat),Number(d.lng))
          // this.servers.push(Number(d.lat), Number(d.lng))
          this.server.lat = Number(d.lat)
          this.server.lng = Number(d.lng)
          this.circle.center.lat = Number(d.lat)
          this.circle.center.lng = Number(d.lng)
          this.serverdata.title=d.title
          this.serverdata.region=d.region
          this.serverdata.external_link=d.external_link
          this.polyline.latlngs.push([Number(d.lat), Number(d.lng)])
          this.polyline.latlngs.push([this.location.data.latitude,this.location.data.longitude])
        })

        lines.map(d => {
          // this.polyline.latlngs.push([Number(d.lat), Number(d.lng)])
          this.office.lat = Number(d.lat)
          this.office.lng = Number(d.lng)
          this.officedata.title = d.title
          this.officedata.region =  d.region
          this.officedata.external_link = d.external_link
        })

      })
      .catch((err) => {
        console.log(err.message);
      });
    },
  }
}
</script>
