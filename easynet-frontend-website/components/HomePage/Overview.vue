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
								
									<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#t-tab3" role="tab">Your Location</a></li>
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
											<ul class="list-group list-group-flush mb-5">
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
												<li class="list-group-item">
													<Weather :city="location.data.city"/>
												</li>
												<li class="list-group-item">
													<Locator :location="location"/>
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
				}
			}
		},

	}
</script>