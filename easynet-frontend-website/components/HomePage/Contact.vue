<template>
	<div>
		<section id="contact" class="contact-us section mt-5">
			<div class="container">
				<div class="contact-head wow fadeInUp" data-wow-delay=".4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">
					<div class="row">
						<div class="col-lg-5 col-12">
							<div class="single-head">
								<div class="contant-inner-title">
									<h4>Contact Information</h4>
									<p>EasyNet Office Center | Layanan dan jasa jaringan internet dengan kualitas powerfull namun dengan harga yang bersahabat</p>
								</div>
								<div class="single-info">
									<i class="lni lni-phone"></i>
									<ul>
										<li>
											<a :href="contact.telp.link" target="_blank btn-link">
												{{contact.telp.string}}
											</a>
										</li>
									</ul>
								</div>
								<div class="single-info">
									<i class="lni lni-envelope"></i>
									<ul>
										<li><a :href="`mailto:${contact.email.link}`">
											{{contact.email.string}}
										</a></li>
									</ul>
								</div>
								<div class="single-info">
									<i class="lni lni-map"></i>
									<ul>
										<li>
											{{contact.lokasi}}
										</li>
									</ul>
								</div>
								<div class="contact-social">
									<h5>Follow Us on</h5>
									<ul>
										<li>
											<a href="#">
												<span class="icon-1"><i class="lni lni-facebook-filled"></i></span>
												<span class="icon-2"><i class="lni lni-facebook-filled"></i></span>
											</a>
										</li>
										<li>
											<a href="#">
												<span class="icon-1"><i class="lni lni-twitter-original"></i></span>
												<span class="icon-2"><i class="lni lni-twitter-original"></i></span>
											</a>
										</li>
										<li>
											<a href="#">
												<span class="icon-1"><i class="lni lni-linkedin-original"></i></span>
												<span class="icon-2"><i class="lni lni-linkedin-original"></i></span>
											</a>
										</li>
										<li>
											<a href="#">
												<span class="icon-1"><i class="lni lni-instagram"></i></span>
												<span class="icon-2"><i class="lni lni-instagram"></i></span>
											</a>
										</li>
										<li>
											<a href="#">
												<span class="icon-1"><i class="lni lni-behance-original"></i></span>
												<span class="icon-2"><i class="lni lni-behance-original"></i></span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="col-lg-7 col-12">
							<div class="form-main">
								<FormContact />
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<div class="map-section">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-12 col-xs-12 col-sm-12">
						<Location/>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import Location from '@/components/Molecules/Location'
	import FormContact from '@/components/Molecules/Contact/ContactForm'

	export default{
		data(){
			return {
				contact:{
					lokasi: 'Jl. Taman Kopo Indah 3 Blk. E No.73, Rahayu, Kec. Margaasih, Bandung, Jawa Barat 40218',
					telp: {
						string: '(022) 54439999',
						link: '02254439999'
					},
					email: {
						string: 'admin@easynet.id',
						link: 'admin@easynet.id'
					}
				}
			}
		},
		components: {
			Location,
			FormContact
		}
	}
</script>