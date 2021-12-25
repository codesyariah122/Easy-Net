<template>
	<div>
		<section id="packages" class="section testimonials">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="section-title align-center">
							<span class="wow fadeInDown" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInDown;">
								{{content.summary}}
							</span>
							<h2 class="wow fadeInUp" data-wow-delay=".4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">
								{{content.heading}}
							</h2>
							<p class="wow fadeInUp" data-wow-delay=".6s" style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInUp;">
								{{content.paragraph}}
							</p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="testimonial-inner wow fadeInUp" data-wow-delay=".3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;">
							<div class="tns-outer" id="tns1-ow">
								<div class="tns-nav" aria-label="Carousel Pagination">
									<button v-for="(item,index) in packages.data" type="button" :data-nav="index" aria-controls="tns1" style="" aria-label="Carousel Page 1" class="" tabindex="-1"></button>
									<!-- <button type="button" data-nav="1" aria-controls="tns1" style="" aria-label="Carousel Page 2" class="" tabindex="-1"></button> -->
								</div>
								<div class="tns-liveregion tns-visually-hidden" aria-live="polite" aria-atomic="true">
									slide <span class="current">5</span>  
									of 7
								</div>
								<div id="tns1-mw" class="tns-ovh">
									<div class="tns-inner" id="tns1-iw">
										<div class="testimonial-slider  tns-slider tns-carousel tns-subpixel tns-calc tns-horizontal" id="tns1" style="transform: translate3d(-36.3636%, 0px, 0px);">

											<div v-for="(item,index) in packages.data" class="single-testimonial tns-item tns-slide-cloned" aria-hidden="true" tabindex="-1">
												<h4 class="text-info">{{item.short_name.toUpperCase()}}</h4>
												<h6 class="text-muted name-product">
													{{item.name}}
												</h6>
												<a class="packages" :data-gall="item.id" :href="`${img_url}/${item.cover}`">
													<img :src="`${img_url}/${item.cover}`" class="img-fluid">
												</a>
												<p class="text-justify">
													{{item.description}} 
												</p>
												<ul class="review mt-3 mb-2">
													<li><i class="lni lni-star-filled"></i></li>
													<li><i class="lni lni-star-filled"></i></li>
													<li><i class="lni lni-star-filled"></i></li>
													<li><i class="lni lni-star-filled"></i></li>
													<li><i class="lni lni-star"></i></li>
												</ul>
												<div class="d-grid gap-2 mt-5">
													<!-- <nuxt-link :to="`/package/${item.slug}`" class="btn btn-primary rounded-pill">Lihat Package</nuxt-link> -->
													<nuxt-link :to="{name: `packages-${item.categories[0].name}-slug`, params: {slug: item.slug}}" class="btn btn-success rounded-pill">Lihat Paket</nuxt-link>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</template>

<script>
	export default{
		props: ['packages'],
		data(){
			return {
				img_url: process.env.IMGURL,
				isMobile: this.$device.isMobile ? 'margin-left:-135px;'  : '',
				content:{
					summary: 'Packages',
					heading: 'Powerfull Package Service',
					paragraph: 'Layanan Internet Dedicated Terbaik untuk Bisnis Anda dengan jaringan Fiber optic dan wireless dengan coverage area yang luas. Berikut list package kami yang siap memenuhi standart kualitas kebutuhan Internet anda.'
				}
			}
		},
		mounted(){
			this.VenoBox(),
			this.TnsSlider()
		},
		methods: {
			VenoBox(){
				new VenoBox({
					selector: '.packages',
					numeration: true,
					infinigall: true,
					share: ['facebook', 'twitter', 'linkedin', 'pinterest', 'download'],
					spinner: 'rotating-plane'
				});
			},
			TnsSlider(){
				tns({
					container: '.testimonial-slider',
					items: this.packages.data.length,
					slideBy: 'page',
					autoplay: false,
					mouseDrag: true,
					gutter: 0,
					nav: true,
					controls: false,
					controlsText: ['<i class="lni lni-chevron-left"></i>', '<i class="lni lni-chevron-right"></i>'],
					responsive: {
						0: {
							items: 1,
						},
						540: {
							items: 1,
						},
						768: {
							items: 1,
						},
						992: {
							items: 2,
						},
						1170: {
							items: 2,
						}
					}
				});
			}
		}
	}
</script>

<style>
	.name-product{
		text-transform: capitalize;
	}
	.single-screen.add-margin{
		margin-left: -15px!important;
	}
</style>
