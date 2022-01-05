<template>
	<div>
		<!-- <pre>
			{{details}}
		</pre> -->
		<section id="pricing" class="pricing-table section">
			<div class="container">
				<div class="row justify-content-center">
					<div :class="`col-lg-12 col-xs-12 col-sm-12 ${isDevice ? 'mb-0' : 'mb-5'}`">
						<div class="d-grid gap-2">
							<nuxt-link to="/#packages" class="btn btn-primary rounded-pill" type="button">Back Homepage</nuxt-link>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="section-title">
							<span class="wow fadeInDown" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInDown;">
								Pricing Table
							</span>
							<h2 class="wow fadeInUp" data-wow-delay=".4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">
								{{details.name}}
							</h2>
							<a class="packages" :data-gall="details.id" :href="`${img_url}/${details.cover}`">
								<img :src="`${img_url}/${details.cover}`" class="img-fluid">
							</a>
							
							<p class="wow fadeInUp mt-5" data-wow-delay=".6s" style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInUp;">{{details.description}}</p>
						</div>
					</div>
				</div>

				<div class="row">
					<div v-for="(item,index) in details.packages" :class="`col-lg-4 col-md-6 col-12 ${isDevice ? 'mb-0' : 'mb-3'}`">

						<div class="single-table wow fadeInUp" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">

							<div class="table-head">
								<h4 class="title">
									{{item.name}}
								</h4>
								<h5>
									{{item.bandwidth +' '+ item.unit}}
								</h5>
								<div v-if="item.price" class="price">
									<p class="amount">IDR.{{item.price}}<span class="duration">per {{item.limit}}</span></p>
								</div>
							</div>

							<!-- <pre>
								{{item}}
							</pre> -->

							<ul class="table-list mt-3">
								<li>Bandwidth Unlimited</li>
								<li>Basic support on 24hours</li>
								<li>Monthly updates</li>
								<li>Free cancelation</li>
								<li>{{item.name}}</li>
							</ul>
							
							<div v-if="item.price" class="button">
								<nuxt-link class="btn" to="/auth/login">Order Now</nuxt-link>
							</div>
							
							<div v-else>
								<a target="_blank" class="btn btn-success rounded-pill" :href="`https://api.whatsapp.com/send?phone=6285322799975&text=Halo+%21%21++easy+net%2C+saya+ingin+order+layanan+internet+${details.short_name}+-+${item.bandwidth}+${item.unit}`">
									Request  <i class="lni lni-whatsapp"></i>
								</a>
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
		layout: 'package',
		name: 'packages-slug',
		data(){
			return {
				slug: this.$route.params.slug,
				details: [],
				isDevice: this.$isMobile,
				img_url: process.env.IMGURL
			}
		},

		mounted(){
			this.DetailPackage(this.slug),
			this.VenoBox()
		},

		methods: {
			DetailPackage(slug){
				const config = {
					token: process.env.APITOKEN,
					baseurl: process.env.BASEURL
				}
				this.$axios.get(`${config.baseurl}/product/detail/${slug}/${config.token}`)
				.then(response => {
					// console.log(response)
					this.details = response.data.data
				})
				.catch(err => console.log(err.message))
			},
			VenoBox(){
				new VenoBox({
					selector: '.packages',
					numeration: true,
					infinigall: true,
					share: ['facebook', 'twitter', 'linkedin', 'pinterest', 'download'],
					spinner: 'rotating-plane'
				});
			},
		}
	}
</script>
