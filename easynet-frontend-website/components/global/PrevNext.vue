<template>
	<div>
		<div class="row justify-content-center">
			<div class="col-md-6">
				<h5 class="text-secondary text-center">Article Lainnya</h5>
				<div class="testimonial-inner wow fadeInUp">
					<div class="tns-outer" id="tns1-ow">

						<div id="tns1-mw" class="tns-ovh">
							<div class="tns-inner" id="tns1-iw">
								<div class="testimonial-slider  tns-slider tns-carousel tns-subpixel tns-calc tns-horizontal" id="tns1" style="transform: translate3d(-36.3636%, 0px, 0px);">
									<div v-if="prev"  class="single-testimonial tns-item tns-slide-cloned" aria-hidden="true" tabindex="-1">
										<NuxtLink :to="{ name: `blog-slug`, params: { slug: prev.slug } }">
											<div class="image">
												<img class="thumb img-fluid card-img-top" :src="require(`~/assets/blog/images/${prev.slug}/${prev.img}`)" alt="#">

												<div class="meta-details text-capitalize">
													<span class="badge bg-primary rounded-pill">
														<img :src="prev.author.img" alt="#" class="rounded-pill circle img-fluid" width="30"> 
														<span>BY {{prev.author.name}}</span>
													</span>

												</div>
											</div>
											<div class="card-body">
												<p class="card-text">{{ prev.title }}</p>
											</div>
										</NuxtLink>
									</div>
									<span v-else>&nbsp;</span>

									<div v-if="prev"  class="single-testimonial tns-item tns-slide-cloned" aria-hidden="true" tabindex="-1">
										<NuxtLink :to="{ name: `blog-slug`, params: { slug: next.slug } }">
											<div class="image">
												<img class="thumb img-fluid card-img-top" :src="require(`~/assets/blog/images/${next.slug}/${next.img}`)" alt="#">

												<div class="meta-details text-capitalize">
													<span class="badge bg-primary rounded-pill">
														<img :src="next.author.img" alt="#" class="rounded-pill circle img-fluid" width="30"> 
														<span>BY {{next.author.name}}</span>
													</span>

												</div>
											</div>
											<div class="card-body">
												<p class="card-text">{{ next.title }}</p>
											</div>
										</NuxtLink>
									</div>
									<span v-else>&nbsp;</span>
								</div>
							</div>
						</div>
					</div>
					

				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props: {
			prev: {
				type: Object,
				default: () => null
			},
			next: {
				type: Object,
				default: () => null
			}
		},
		head:{
			link: [
			{ rel: 'stylesheet', type: 'text/css', href: '/assets/css/main.css'},
			{ rel: 'stylesheet', type: 'text/css', href: '/assets/css/new-style.css'},
			{ rel: 'stylesheet', type: 'text/css', href: '/assets/css/LineIcons.2.0.css'},
			{ rel: 'stylesheet', type: 'text/css', href: '/assets/css/animate.css'},
			{ rel: 'stylesheet', type: 'text/css', href: '/assets/css/tiny-slider.css'},
			{ rel: 'stylesheet', type: 'text/css', href: '/assets/css/glightbox.min.css'},
			{ rel: 'stylesheet', type: 'text/css', href: '/assets/venobox/dist/venobox.min.css'}
			],

			script: [
			{
				src: '/assets/js/main.js',
				type: 'text/javascript'
			},
			{
				src: '/assets/js/tiny-slider.js',
				type: 'text/javascript'
			},
			{
				src: '/assets/js/glightbox.min.js',
				type: 'text/javascript'
			},
			{
				src: '/assets/js/imagesloaded.min.js',
				type: 'text/javascript'
			},
			{
				src: '/assets/vendor/aos/aos.js',
				type: 'text/javascript'
			},
			{
				src: '/assets/js/isotope.min.js',
				type: 'text/javascript'
			},
			{
				src: 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js'
			},
			{
				src: '/assets/venobox/dist/venobox.min.js',
				type: 'text/javascript'
			}
			]
		},
		mounted(){
			this.VenoBox(),
			this.TnsSlider()
		},
		methods:{
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
					items: this.packages ? this.packages.data.length : '',
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
							items: 1,
						},
						1170: {
							items: 1,
						}
					}
				});
			}
		}
	}
</script>