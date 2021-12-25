<template>
	<div>
		<client-only>

			<l-map style="height:350px; width: 600px;" :zoom="zoom" :center="center">
				<l-layer-group ref="features">
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
									{{ central.title }} 
								</span>
								<br />
								<small class="text-success">
									{{ central.region }}
								</small>
								<br />
								<img :src="require('~/assets/marker-custom/tower.png')" width="35"/>
								<br />
								<!-- <a :href="coordinate.external_link" class="btn btn-primary btn-sm rounded-pill">View Location</a> -->
							</center>
						</l-popup>
					</l-marker>
					<l-popup > 
						<span> Yay I was opened by {{caller}}</span>
						<br>
						<span class="font-weight-bold bd-highlight">
							{{central.title}}
						</span><br>
						<img :src="icons[7]" width="35">
					</l-popup>
					<l-marker :lat-lng="markerLatLng" @click="openPopUp(markerLatLng, 'marker')">
						<l-icon
						:icon-size="iconSizeClient"
						:icon-anchor="staticAnchor"
						:icon-url="icons[1]"
						:shadow-url="icons[3]"
						/>
						<l-popup>
							<center class="container">
								<span class="font-weight-bold bd-highlight">
									Your Location :  {{location.city}}  - {{ location.region }}
								</span><br>

								<br>
								<img :src="icons[6]" width="50">
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
									<a :href="coordinate.external_link" class="btn btn-primary btn-sm text-white rounded-pill">View Location</a>
								</center>
							</l-popup>
						</l-marker>
						<!-- <l-polyline :lat-lngs="polyline.latlngs" :color="polyline.color[0]" /> -->
					</div>

					<l-circle
					:lat-lng="markerLatLng"
					:radius="circle.radius"
					:color="circle.color"
					@click="openPopUp(circle.center, 'circle')"
					/>
					<l-polyline :lat-lngs="polyline.latlngs" :color="polyline.color[1]" />
					<l-tile-layer :url="url" :attribution="attribution"></l-tile-layer>
				</l-layer-group>
				
			</l-map>
		</client-only>
	</div>
</template>



<script>
	export default{
		props: ['location'],
		data () {
			return {
				url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
				attribution:
				'&copy; <a target="_blank" href="http://osm.org/copyright">OpenStreetMap</a> contributors',
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
				polyline: {
					latlngs: '',
					color: ["coral", "green"]
				},
				zoom: '',
				isDeviceMobile: this.$device.isMobile,
				center: [this.location.latitude, this.location.longitude],
				markerLatLng: [this.location.latitude, this.location.longitude],
				caller: null,
				circle: {
					center: [this.location.latitude, this.location.longitude],
					radius: (this.$device.isMobile && this.location.city === "Bandung") ? 30000  : 35000,
					color: 'red'
				},
				icons: {
					1: require("assets/marker-custom/router1.png"),
					2: require("assets/marker-custom/tower.png"),
					3: require("assets/marker-custom/marker-shadow.png"),
					4: require("assets/marker-custom/tower-5.png"),
					5: require("assets/marker-custom/tower-3.png"),
					6: require("assets/marker-custom/home.png"),
					7: require("assets/marker-custom/server.png")
				},
				staticAnchor: [10, 15],
				iconSize: [70, 70],
				iconSizeClient: [50,50],
				marker: {
					iconSize: [50,50],
					staticAnchor: [5,10]
				}
			};
		},

		beforeMount(){
			this.starMap()
		},
		mounted(){
			this.Center(),
			this.Coverege()
			// this.polyline.latlngs.push([-6.9217, 107.6071])
		},

		methods: {
			starMap(){
				this.zoom = 11
			},
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
					this.servers = res.data.data;
					this.servers.map((d) => {
						d.maps.map((m) => {
							this.central.title = m.title;
							this.central.region = m.region;
							this.central.center.lat = m.lat;
							this.central.center.lng = m.lng;
							// this.polyline.latlngs.push([m.lat, m.lng])
							// this.circle.center.push(m.lat,m.lng)
						});
					});
				})
				.catch((err) => {
					console.log(err.message);
				});
			},
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
          				});
					});
				})
				.catch((err) => {
					console.log(err.message);
				});
			},
		}
	}
</script>


<style scoped>
	@import 'leaflet/dist/leaflet.css'
</style>