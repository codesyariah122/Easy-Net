hrd@saptakarsa.com

wwww.saptakarsaprima.com

0812 8910 7011 - mark sihombing


circle: {
					center: [],
					radius: this.$device.isMobile ? 50000 : 25000,
					color: ['green','red','brown'],
				},

				-6.971627551665847

				107.54649735137858


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
								<!-- <a :href="coordinate.external_link" class="btn btn-primary btn-sm rounded-pill">View Location</a> -->
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
				</div><div v-for="(item, index) in coordinates">
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
								<!-- <a :href="coordinate.external_link" class="btn btn-primary btn-sm rounded-pill">View Location</a> -->
							</center>
						</l-popup>
					</l-marker>




				<l-circle
				:lat-lng="markerLatLng"
				:radius="circle.radius"
				:color="circle.color"
				@click="openPopUp(circle.center, 'circle')"
				/>
				<l-polyline :lat-lngs="polyline.latlngs" :color="polyline.color[1]" />




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
					latlngs: [],
					color: ["coral", "green"]
				},
				zoom: (this.$device.isMobile && this.location.city === "Bandung") ? 10 : 10,
				isDeviceMobile: this.$device.isMobile,
				center: [this.location.latitude, this.location.longitude],
				markerLatLng: [-6.9217, 107.6071],
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


		mounted(){
			this.Center(),
			this.Coverege()
			// this.polyline.latlngs.push([-6.9217, 107.6071])
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



<h3 class="content-heading">Check Your Location</h3>
			<!-- <pre>
				{{polyline.latlngs}}
			</pre> -->
			<ul class="list-group list-group-flush mb-5">
				<li class="list-group-item">
					Your IP Address : {{location.ip}}
				</li>
				<li class="list-group-item">
					City : {{location.city}}
				</li>
				<li class="list-group-item">
					Province : {{location.region}}
				</li>
				<li class="list-group-item">
					Country : {{location.country_name}}
				</li>
				<li class="list-group-item">
					Timezone : {{location.timezone}}
				</li>
				<li class="list-group-item">
					Your ISP : {{location.org}}
				</li>
			</ul>