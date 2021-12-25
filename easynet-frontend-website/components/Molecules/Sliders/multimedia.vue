<template>
	<div>
		<div class="screen-head">
			<div class="multimedia">
				<div>
					<a class="multimedias" data-gall="other1" :href="require(`~/assets/images/features/other/other8.jpg`)">
						<img :src="require(`~/assets/images/features/other/other8.jpg`)" class="img-fluid">
					</a>
				</div>
				<div>
					<a class="multimedias" data-gall="other2" :href="require(`~/assets/images/features/multimedia/multi5.webp`)">
						<img :src="require(`~/assets/images/features/multimedia/multi5.webp`)" class="img-fluid">
					</a>
				</div>
				<div>
					<a class="multimedias" data-gall="other3" :href="require(`~/assets/images/features/multimedia/multi1.webp`)">
						<img :src="require(`~/assets/images/features/multimedia/multi1.webp`)" class="img-fluid">
					</a>
				</div>
				<div>
					<a class="multimedias" data-gall="other4" :href="require(`~/assets/images/features/multimedia/multi2.jpg`)">
						<img :src="require(`~/assets/images/features/multimedia/multi2.jpg`)" class="img-fluid">
					</a>
				</div>
				<div >
					<a class="multimedias" data-gall="other5" :href="require(`~/assets/images/features/multimedia/multi3.webp`)">
						<img :src="require(`~/assets/images/features/multimedia/multi3.webp`)" class="img-fluid">
					</a>
				</div>
				<div >
					<a class="multimedias" data-gall="other6" :href="require(`~/assets/images/features/multimedia/multi4.webp`)">
						<img :src="require(`~/assets/images/features/multimedia/multi4.webp`)" class="img-fluid">
					</a>
				</div>
				<div>
					<a class="multimedias" data-gall="other7" :href="require(`~/assets/images/features/other/other7.jpg`)">
						<img :src="require(`~/assets/images/features/other/other7.jpg`)" class="img-fluid">
					</a>
				</div>
				<div>
					<a class="multimedias" data-gall="other8" :href="require(`~/assets/images/features/other/other9.webp`)">
						<img :src="require(`~/assets/images/features/other/other9.webp`)" class="img-fluid">
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
					selector: '.multimedias',
					numeration: true,
					infinigall: true,
					share: ['facebook', 'twitter', 'linkedin', 'pinterest', 'download'],
					spinner: 'rotating-plane'
				});
			},
			Carousel(){
				tns({
					container: '.multimedia',
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
	.multimedias img{
		width: 900px;
	}
</style>