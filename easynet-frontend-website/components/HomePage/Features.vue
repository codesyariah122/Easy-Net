<template>
	<div>
		<section id="features" class="services index2 section">
			<div class="container">
				<div class="row">
					<div class="col-lg-8 col-12">
						<div class="section-title align-left">
							<span class="wow fadeInDown" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInDown;">
								{{content.summary}}
							</span>
							<h2 class="wow fadeInUp" data-wow-delay=".4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">{{content.heading}}</h2>
							<p class="wow fadeInUp" data-wow-delay=".6s" style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInUp;"  v-html="content.paragraph"></p>
						</div>
					</div>
					
					<div class="col-lg-4 col-12">
						<img src="/assets/images/about/speedtest.gif" class="img-fluid mb-2 mt-2" alt="#">
						<div class="review-content wow fadeInRight mb-3" data-wow-delay=".3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInRight;">
							<h3>4.5</h3>
							<ul>
								<li><i class="lni lni-star-filled"></i></li>
								<li><i class="lni lni-star-filled"></i></li>
								<li><i class="lni lni-star-filled"></i></li>
								<li><i class="lni lni-star-filled"></i></li>
								<li><i class="lni lni-star-half"></i></li>
							</ul>
							<p>Dari 10,000 Pengguna</p>
						</div>
					</div>
				</div>

				<div class="row justify-content-center mt-5 mb-50">
					<div class="col-lg-12 col-12 col-xs-12 col-sm-12">
						<Slider/>
					</div>
				</div>
				<br>
				<br>
				<br>

				<div class="single-head">
					<img class="service-patern wow fadeInLeft" data-wow-delay=".4s" src="assets/images/service/service-patern.png" alt="#" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInLeft;">
					<div class="row">
						<div v-for="(item,index) in features" class="col-lg-3 col-md-6 col-12" :key="item.id">
							<div class="single-service wow fadeInUp" :data-wow-delay="item.wow_delay" :style="`visibility: visible; animation-delay: ${item.wow_delay}; animation-name: fadeInUp;`">
								<div v-html="item.content"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</template>

<script>
	import Slider from '@/components/Molecules/SliderFeatures'

	export default{
		components:{
			Slider
		},
		data(){
			return{
				content:{
					summary: 'complete features',
					heading: 'Memberikan pengalaman yang lebih baik untuk memenuhi kebutuhan anda dalam menggunakan layanan jaringan internet. ',
					paragraph: 'Tidak di ragukan lagi infrastruktur internet telah menjadi sebuah komoditi vital. Dalam perkembangan bisnis, social contact, hoby dan entertainment, yang tengah berkembang pesat di era milenial ini. Internet memberikan efek yang besar terhadap fleksibilita, tentunya di iringi dengan kualitas jaringan internet yang baik dari provider itu sendiri, mulai dari kemudahan pendaftaran, pelayanan yang ramah dan gesit, kecepatan akses internet yang prima, jaringan yang stabil. Dan <span class="text-primary">EasyNet</span> memenuhi semua kriteria tersebut.'
				},
				features: [
					{
						id:1,
						content:`
							<h3><a href="service-single.html">Legal Dan Terpercaya</a></h3>
							<div class="icon">
							<i class="lni lni-lock-alt"></i>
							</div>
							<p>Dengan komitmen dan infrastruktur kami yang mutakhir dan telah tersebar di beberapa wilayah. Telah di percaya sebagai penyedia layanan &amp; jasa Jaringan internet yang handal.</p
						`,
						wow_delay: '.2s'
					},
					{
						id:2,
						content:`
							<h3><a href="service-single.html">Dedicated Fiber Optic</a></h3>
							<div class="icon">
							<i class="lni lni-headphone"></i>
							</div>
							<p>Menawarkan berbagai layanan telekomunikasi dan multimedia untuk memenuhi permintaan bisnis dan konsumen dengan harga yang kompetitif.</p>
						`,
						wow_delay: '.4s'
					},
					{
						id:3,
						content:`
							<h3><a href="service-single.html">Layanan yang Fleksibel</a></h3>
							<div class="icon">
							<i class="lni lni-credit-cards"></i>
							</div>
							<p>
							Apapun kebutuhan aktifitas Anda Easynet siap menjadi partner terbaik untuk memenuhi kebutuhan anda dengan solusi terbaik yang akan kami berikan.
							</p>
						`,
						wow_delay: '.6s'
					},
					{
						id:4,
						content:`
							<h3><a href="service-single.html">24/7 Customer Service</a></h3>
							<div class="icon">
							<i class="lni lni-rocket"></i>
							</div>
							<p>Easynet memberikan dukungan teknis selama 24 jam penuh untuk memenuhi layanan akses internet yang handal.</p>
						`,
						wow_delay: '.8s'
					}
				]
			}
		},
	}
</script>