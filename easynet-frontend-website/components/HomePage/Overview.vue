<template>
	<div>
		<section id="overview" class="about-us index2 section">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-12">
						<div class="about-left">
							<div class="section-title align-left">
								<span class="wow fadeInDown" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInDown;">
									{{content.summary}}
								</span>
								<h2 class="wow fadeInUp" data-wow-delay=".4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">
									{{content.heading}}
								</h2>
								<p class="wow fadeInUp" data-wow-delay=".6s" style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInUp;" v-html="content.paragraph"></p>
							</div>
							<div class="about-tab wow fadeInUp" data-wow-delay=".3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;">

								<ul class="nav nav-tabs" id="myTab" role="tablist">
									<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#t-tab1" role="tab">Coverege</a></li>
								
									<li class="nav-item"><a @click="Locator" class="nav-link" data-toggle="tab" href="#t-tab3" role="tab">Your Location</a></li>
								</ul>

								<div class="tab-content" id="myTabContent">

									<div class="tab-pane fade show active" id="t-tab1" role="tabpanel">
										<div class="tab-content">
											<h3 class="content-heading">Coverege Area</h3>
											<Area/>
										</div>
									</div>

									<div class="tab-pane fade" id="t-tab3" role="tabpanel">
										<div class="tab-content">
											
			
											<h3 class="content-heading mt-5">Your Location</h3>
											<!-- <pre>
												{{polyline.latlngs}}
											</pre> -->
											<Locator :location="location" :map="map" :loading_map="loading_map"/>
											<ul class="list-group list-group-flush mb-5">
												<li class="list-group-item">
													<Weather :city="location.data.city"/>
												</li>
												<li class="list-group-item">
													Coordinates : {{location.data.latitude}}, {{location.data.longitude}}
												</li>
												<li class="list-group-item">
													Your IP Address : {{location.data.ip}}
												</li>
												<li class="list-group-item">
													City : {{location.data.city}}
												</li>
												<li class="list-group-item">
													Province : {{location.data.region}}
												</li>
												<li class="list-group-item">
													Country : {{location.data.country_name}}
												</li>
												<li class="list-group-item">
													Timezone : {{location.data.timezone}}
												</li>
												<li class="list-group-item">
													Your ISP : {{location.data.org}}
												</li>
											</ul>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-12">
						<div class="about-right wow fadeInRight" data-wow-delay=".4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">
							<img src="/assets/images/animated/anim9.gif" alt="#" width="300">
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</template>
<script>
	import Area from '@/components/Molecules/Covereges/Area'
	import Locator from '@/components/Molecules/Covereges/Locator'
	import Weather from '@/components/Molecules/Covereges/Weather'

	export default{
		props:['location'],
		components:{
			Area,
			Locator,
			Weather
		},
		data(){
			return {
				content:{
					summary: 'wide coverage',
					heading: 'ÉasyNet mempunyai cakupan area yang luas',
					paragraph: 'Dengan dukungan komunitas dan di dukung dengan segala infrastruktur high performance dan penggunaan tools terkini yang dapat di pastikan <span class="text-primary">EasyNet</span> sebagai partner penyedia layanan internet berbasis fiber dan frekuensi wireless yang High Performance'
				},
				loading_map: null,
				map: {
					url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
					attribution:
					'&copy; <a target="_blank" href="http://osm.org/copyright">EasyNetMap</a> contributors',
					zoom: this.$device.isMobile ? 11 : 11.5,
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
			}
		},

		methods: {
			Locator() {
				this.loading_map=true
				const config = {
					url: process.env.BASEURL,
					token: process.env.APITOKEN,
				};
				this.$axios
				.get(`${config.url}/coordinates/${config.token}`)
				.then((res) => {
					setTimeout(() => {
						this.loading_map=false
						this.map.coordinates = res.data.data[1].maps
							let lines = res.data.data[0].maps
							this.map.coordinates.map(d => {
					          // this.circle.center.push(Number(d.lat),Number(d.lng))
					          // this.servers.push(Number(d.lat), Number(d.lng))
					          this.map.server.lat = Number(d.lat)
					          this.map.server.lng = Number(d.lng)
					          this.map.circle.center.lat = Number(d.lat)
					          this.map.circle.center.lng = Number(d.lng)
					          this.map.serverdata.title=d.title
					          this.map.serverdata.region=d.region
					          this.map.serverdata.external_link=d.external_link
					          this.map.polyline.latlngs.push([Number(d.lat), Number(d.lng)])
					          this.map.polyline.latlngs.push([this.location.data.latitude,this.location.data.longitude])
					      })

							lines.map(d => {
					          // this.polyline.latlngs.push([Number(d.lat), Number(d.lng)])
					          this.map.office.lat = Number(d.lat)
					          this.map.office.lng = Number(d.lng)
					          this.map.officedata.title = d.title
					          this.map.officedata.region =  d.region
					          this.map.officedata.external_link = d.external_link
					      })
					}, 1500)
					

				})
				.catch((err) => {
					console.log(err.message);
				});
			},
		}
	}
</script>