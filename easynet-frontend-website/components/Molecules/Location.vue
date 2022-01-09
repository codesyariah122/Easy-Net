<template>
	<div style="height: 450px; width: 100%">
		<client-only>
			<l-map
			ref="myMap"
			:zoom="zoom"
			:center="center"
			>

			<!-- <l-circle
			:lat-lng="center"
			:radius="circle.radius"
			:color="circle.color"
			/> -->
				<div v-for="(item,index) in coordinates">
					<l-marker v-for="coordinate in item.maps" :lat-lng="coordinate" :key="coordinate.id">
						
						<l-icon
						:icon-size="iconSize"
						:icon-anchor="staticAnchor"
						:icon-url="icons[coordinate.id]"
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
								<!-- <pre>
									{{coordinate.id}}
								</pre> -->
								<img :src="(coordinate.id === 1) ? icons[4] : icons[7]" width="155">
								<br><br>
								<a :href="coordinate.external_link" class="btn btn-primary btn-sm text-white rounded-pill">View Location</a>
							</center>
						</l-popup>
					</l-marker>
					<!-- <l-polyline :lat-lngs="polyline.latlngs" :color="polyline.color"/> -->
					<l-tile-layer :url="url" :attribution="attribution">

					</l-tile-layer>
				</div>
			</l-map>
		</client-only>
    </div>
</template>

<script>
	export default {
		data () {
			return {
				ip:'',
				coordinates: [],
				url: 'http://{s}.tile.osm.org/{z}/{x}/{y}.png',
				attribution:
				'&copy; <a target="_blank" href="http://osm.org/copyright">EasyNetMap</a> contributors',
				zoom: this.$device.isMobile ? 14 : 15,
				center: {
					lat: '',
					lng: ''
				},
				bounds: null,
				regionCenter: [],
				address: {
					long: '',
					display: '',
				},
				polyline: {
					latlngs: [],
					color: 'green'
				},
				circle: {
					center: '',
					radius: 2500,
					color: 'red'
				},
				icons: {
					1: require('assets/marker-custom/building-icon-3.png'),
					2: require('assets/marker-custom/tower.png'),
					3: require('assets/marker-custom/marker-shadow.png'),
					4: require('assets/marker-custom/smart-office.gif'),
					5: require("assets/marker-custom/connect-wifi.gif"),
					6: require("assets/marker-custom/tower-wifi.gif"),
					7: require("assets/marker-custom/tower-wifi-2.gif"),
					8: require("assets/marker-custom/tower-wifi-3.gif")
				},
				staticAnchor: [10, 15],
				iconSize: [70,80]
			}
		},

		mounted(){
			this.Coordinates()
		},

		methods:{
			Coordinates(){
				const config={
					url: process.env.BASEURL,
					token: process.env.APITOKEN
				}
				this.$axios.get(`${config.url}/coordinates/${config.token}`)
				.then(res => {
					this.coordinates = res.data.data
					this.coordinates.map(d => {
						d.maps.map(m => {
							this.center.lat = m.lat
							this.center.lng = m.lng
							this.regionCenter.push(m.lat)
							this.regionCenter.push(m.lng)
						})
					})
					
					this.coordinates.map(d => {
						d.maps.map((m,i) => {
							this.polyline.latlngs.push([m.lat,m.lng])
						})
					})
					
				})
				.catch(err => {
					console.log(err.message)
				})
			}
		}

	}
</script>