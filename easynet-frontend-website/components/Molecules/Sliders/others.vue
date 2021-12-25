<template>
	<div>
		<div class="screen-head">
			<div class="other-images">
				<div>
					<a class="others" data-gall="multi1" :href="require(`~/assets/images/features/other/other17.jpg`)">
						<img :src="require(`~/assets/images/features/other/other17.jpg`)" class="img-fluid">
					</a>
				</div>
				<div>
					<a class="others" data-gall="multi2" :href="require(`~/assets/images/features/other/other16.jpg`)">
						<img :src="require(`~/assets/images/features/other/other16.jpg`)" class="img-fluid">
					</a>
				</div>
				<div>
					<a class="others" data-gall="multi3" :href="require(`~/assets/images/features/other/other13.jpg`)">
						<img :src="require(`~/assets/images/features/other/other13.jpg`)" class="img-fluid">
					</a>
				</div>
				<div>
					<a class="others" data-gall="multi4" :href="require(`~/assets/images/features/other/other1.webp`)">
						<img :src="require(`~/assets/images/features/other/other1.webp`)" class="img-fluid">
					</a>
				</div>
				<div>
					<a class="others" data-gall="multi5" :href="require(`~/assets/images/features/other/other2.jpg`)">
						<img :src="require(`~/assets/images/features/other/other2.jpg`)" class="img-fluid">
					</a>
				</div>
				<div>
					<a class="others" data-gall="multi6" :href="require(`~/assets/images/features/other/other3.webp`)">
						<img :src="require(`~/assets/images/features/other/other3.webp`)" class="img-fluid">
					</a>
				</div>
				<div>
					<a class="others" data-gall="multi7" :href="require(`~/assets/images/features/other/other4.jpeg`)">
						<img :src="require(`~/assets/images/features/other/other4.jpeg`)" class="img-fluid">
					</a>
				</div>
				<div>
					<a class="others" data-gall="multi8" :href="require(`~/assets/images/features/other/other5.jpg`)">
						<img :src="require(`~/assets/images/features/other/other5.jpg`)" class="img-fluid">
					</a>
				</div>
				<div>
					<a class="others" data-gall="multi9" :href="require(`~/assets/images/features/other/other6.jpg`)">
						<img :src="require(`~/assets/images/features/other/other6.jpg`)" class="img-fluid">
					</a>
				</div>
				
				<div>
					<a class="others" data-gall="multi10" :href="require(`~/assets/images/features/other/other10.webp`)">
						<img :src="require(`~/assets/images/features/other/other10.webp`)" class="img-fluid">
					</a>
				</div>
				<div>
					<a class="others" data-gall="multi11" :href="require(`~/assets/images/features/other/other11.jpg`)">
						<img :src="require(`~/assets/images/features/other/other11.jpg`)" class="img-fluid">
					</a>
				</div>
				<div>
					<a class="others" data-gall="multi12" :href="require(`~/assets/images/features/other/other12.jpg`)">
						<img :src="require(`~/assets/images/features/other/other12.jpg`)" class="img-fluid">
					</a>
				</div>
				<div>
					<a class="others" data-gall="multi13" :href="require(`~/assets/images/features/other/other14.jpg`)">
						<img :src="require(`~/assets/images/features/other/other14.jpg`)" class="img-fluid">
					</a>
				</div>
				<div>
					<a class="others" data-gall="multi14" :href="require(`~/assets/images/features/other/other15.jpg`)">
						<img :src="require(`~/assets/images/features/other/other15.jpg`)" class="img-fluid">
					</a>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default{
		mounted(){
			this.VenoBox(),
			this.Carousel()
		},

		methods:{
			VenoBox(){
				new VenoBox({
					selector: '.others',
					numeration: true,
					infinigall: true,
					share: ['facebook', 'twitter', 'linkedin', 'pinterest', 'download'],
					spinner: 'rotating-plane'
				});
			},
			Carousel(){
				tns({
					container: '.other-images',
					items: 1,
					slideBy: "page",
					mouseDrag: true,
					swipeAngle: false,
					autoplay: true,
					autoplayButtonOutput: false,
					speed: 200,
					responsive: {
						640: {
							edgePadding: 20,
							gutter: 20,
							items: 1
						},
						700: {
							gutter: 30,
							items: 3
						},
						900: {
							items: 3
						}
					}
				})
			},
			
		}
	}
</script>

<style>
	.others  img{
		width: 900px;
	}
</style>