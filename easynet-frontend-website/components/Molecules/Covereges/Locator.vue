<template>
  <div>
    <client-only>
      <!-- <pre>
        {{map}}
      </pre> -->
        <div v-if="loading_map">
          <div class="d-flex justify-content-center">
            <div class="spinner-grow text-info" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          </div>
        </div>
        <l-map v-else :style="`${isMobile ? 'height:350px; width: 100%;' : 'height:350px; width: 600px;'}`" :zoom="map.zoom" :center="map.center">
          <l-marker :lat-lng="map.server">
            <l-icon
            :icon-size="map.iconServer.iconSize"
            :icon-anchor="map.iconServer.staticAnchor"
            :icon-url="map.icons[2]"
            :shadow-url="map.icons[3]"
            />
            <l-popup>
              <center class="container">
                <span class="font-weight-bold bd-highlight">
                  {{map.serverdata.title}}
                </span><br>
                <small class="text-success">
                  {{ map.serverdata.region }}
                </small>
                <br>
                <img :src="map.icons[4]" width="75">
                <br><br>
                <a :href="map.serverdata.external_link" class="btn btn-primary btn-sm text-white rounded-pill">View Location</a>
              </center>
            </l-popup>
          </l-marker>

          <l-tile-layer :url="map.url" :attribution="map.attribution"></l-tile-layer>
          <l-layer-group ref="features">
            <l-popup >
              <center>
                <span class="text-success"> 
                  <address>
                    Your area {{map.caller}} its ready to connect 
                  </address>
                  <strong class="text-primary">EasyNet</strong> </span>
                  <br>
                  <img :src="map.icons[2]" class="img-fluid" width="40">
              </center>
            </l-popup>
          </l-layer-group>
          <l-marker :lat-lng="map.markerLatLng" @click="openPopUp(map.markerLatLng, 'marker')">
            <l-icon
            :icon-size="map.iconClient.iconSize"
            :icon-anchor="map.iconClient.staticAnchor"
            :icon-url="map.icons[1]"
            :shadow-url="map.icons[3]"
            />
            <l-popup>
              <center class="container">
                <span class="font-weight-bold bd-highlight">
                 Your Location  : {{location.data.city}}  - {{ location.data.region }}
               </span><br>
               <br>
               <img :src="map.icons[6]" width="75">
             </center>
           </l-popup>
         </l-marker>
         <l-circle
         :lat-lng="map.center"
         :radius="map.circle.radius"
         :color="map.circle.color"
         @click="openPopUp(map.circle.center, `${location.data.city}-${location.data.region}`)"
         />
         <l-polyline :lat-lngs="map.polyline.latlngs" :color="map.polyline.color" />
       </l-map>
    </client-only>
  </div>
</template>

<script>
export default {
  props: ['location', 'map', 'loading_map'],
  data(){
    return {
      isMobile: this.$device.isMobile
    }
  },
  methods: {
    openPopUp (latLng, caller) {
      this.caller = caller;
      this.$refs.features.mapObject.openPopup(latLng);
    },
    
  }
}
</script>
