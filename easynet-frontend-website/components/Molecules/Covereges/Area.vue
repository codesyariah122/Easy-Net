<template>
  <div>
    <!-- <pre>
      {{polyline.latlngs}}
    </pre> -->
    <!-- <div v-for="(item, index) in polyline.latlngs">
        <pre>
          {{index}}
        </pre>
        <pre>
          {{polyline.color[index]}}
        </pre>
    </div> -->
    <!-- <pre>
      {{circle.center[0]}}
    </pre> -->

    <client-only>
      <l-map
        :style="`${isMobile ? 'height:400px; width: 100%;' : 'height:450px; width: 900px;'} z-index: 0;`"
        :zoom="zoom"
        :center="central.center"
      >
        <l-marker :lat-lng="central.center">
          <l-icon
            :icon-size="iconSize"
            :icon-anchor="staticAnchor"
            :icon-url="icons[2]"
            :shadow-url="icons[3]"
          />
          <l-popup>
            <center class="container">
              <span class="font-weight-bold bd-highlight">
                {{ central.title }} </span
              ><br />
              <small class="text-success">
                {{ central.region }}
              </small>
              <br />
              <img
                :src="require('~/assets/marker-custom/tower.png')"
                width="35"
              />
              <br />
              <a :href="central.external_link" target="_blank" class="text-white btn btn-primary btn-sm rounded-pill">View Location</a>
            </center>
          </l-popup>
        </l-marker>

        <div v-for="(item, index) in coordinates">
          <l-marker v-for="coordinate in item.maps" :lat-lng="coordinate" :key="coordinate.id">
            <l-icon
            :icon-size="marker.iconSize"
            :icon-anchor="marker.staticAnchor"
            :icon-url="icons[5]"
            :shadow-url="icons[3]"
            />
              <l-popup>
                <center class="container">
                  <span class="font-weight-bold bd-highlight">
                    {{coordinate.title}}
                  </span><br>
                  <small class="text-success">
                    {{ coordinate.region }}
                  </small>
                  <br>
                  <img :src="icons[4]" width="75">
                  <br><br>
                  <a v-if="coordinate.external_link" :href="coordinate.external_link" class="btn btn-primary btn-sm text-white rounded-pill">View Location</a>
                </center>
              </l-popup>
            </l-marker>

          <l-circle
            :lat-lng="central.center"
            :radius="circle.radius"
            :color="circle.color"
          />
          <l-polyline :lat-lngs="polyline.latlngs" :color="polyline.color" />
          <l-tile-layer :url="url" :attribution="attribution"></l-tile-layer>
        </div>
      </l-map>
    </client-only>
    
  </div>
</template>

<script>
export default {
  data() {
    return {
      url: "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
      attribution:
        '&copy; <a target="_blank" href="http://osm.org/copyright">EasyNetMap</a> contributors',
      zoom: this.$device.isMobile ? 9 : 11,
      isMobile: this.$device.isMobile,
      coordinates: [],
      servers: [],
      central: {
        title: "",
        region: "",
        center: {
          lat: "",
          lng: "",
        },
      },
      center: {
        lat: "",
        lng: "",
      },
      circle: {
        center: [],
        radius: this.$device.isMobile ? 50000 : 50000,
        color: "green",
      },
      polyline: {
        latlngs: [],
        color: "red",
      },
      icons: {
        1: require("assets/marker-custom/easy-icon-2.png"),
        2: require("assets/marker-custom/tower.png"),
        3: require("assets/marker-custom/marker-shadow.png"),
        4: require("assets/marker-custom/tower-5.png"),
        5: require("assets/marker-custom/tower-3.png"),
      },
      staticAnchor: [10, 15],
      iconSize: [90, 90],
      marker: {
        iconSize: [90,90],
        staticAnchor: [7,12]
      }
    };
  },

  mounted() {
    this.Center(),
    this.Coverege()
  },

  methods: {
    Coverege() {
      const config = {
        url: process.env.BASEURL,
        token: process.env.APITOKEN,
      };

      this.$axios
        .get(`${config.url}/covereges/${config.token}`)
        .then((res) => {
          this.coordinates = res.data.data;
          this.coordinates.map((d) => {
            d.maps.map((m, i) => {
              this.circle.center.push([m.lat, m.lng]);
              this.polyline.latlngs.push([m.lat, m.lng]);
              // this.polyline.latlngs.push([
              //   -7.157187235719458, 107.39845565357021,
              // ]);
            });
          });
        })
        .catch((err) => {
          console.log(err.message);
        });
    },

    Center() {
      const config = {
        url: process.env.BASEURL,
        token: process.env.APITOKEN,
      };
      this.$axios
        .get(`${config.url}/coordinates/${config.token}`)
        .then((res) => {
          this.servers = res.data.data;
          this.servers.map((d) => {
            d.maps.map((m) => {
              this.central.title = m.title;
              this.central.region = m.region;
              this.central.external_link = m.external_link;
              this.central.center.lat = m.lat;
              this.central.center.lng = m.lng;
            });
          });
        })
        .catch((err) => {
          console.log(err.message);
        });
    },
  },
};
</script>
