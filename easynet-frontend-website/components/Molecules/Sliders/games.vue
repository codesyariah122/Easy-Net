<template>
	<div>
		<div class="screen-head">
			<div class="game">
				<div>
					<a class="my-games" data-gall="game1" :href="require(`~/assets/images/features/game/game1.jpg`)">
						<img :src="require(`~/assets/images/features/game/game1.jpg`)" class="img-fluid">
					</a>
				</div>
				<div>
					<a class="my-games" data-gall="game2" :href="require(`~/assets/images/features/game/game2.jpg`)">
						<img :src="require(`~/assets/images/features/game/game2.jpg`)" class="img-fluid">
					</a>
				</div>
				<div>
					<a class="my-games" data-gall="game3" :href="require(`~/assets/images/features/game/game3.jpg`)">
						<img :src="require(`~/assets/images/features/game/game3.jpg`)" class="img-fluid">
					</a>
				</div>
				<div>
					<a class="my-games" data-gall="game4" :href="require(`~/assets/images/features/game/game4.jpg`)">
						<img :src="require(`~/assets/images/features/game/game4.jpg`)" class="img-fluid">
					</a>
				</div>
				<div>
					<a class="my-games" data-gall="game5" :href="require(`~/assets/images/features/game/game5.jpg`)">
						<img :src="require(`~/assets/images/features/game/game5.jpg`)" class="img-fluid">

					</a>
				</div>
				<div>
					<a class="my-games" data-gall="game6" :href="require(`~/assets/images/features/game/game6.jpg`)">
						<img :src="require(`~/assets/images/features/game/game6.jpg`)" class="img-fluid">
					</a>
				</div>
				<div>
					<a class="my-games" data-gall="game7" :href="require(`~/assets/images/features/game/game7.jpg`)">
						<img :src="require(`~/assets/images/features/game/game7.jpg`)" class="img-fluid">
					</a>
				</div>
				<div>
					<a class="my-games" data-gall="game8" :href="require(`~/assets/images/features/game/game8.jpg`)">
						<img :src="require(`~/assets/images/features/game/game8.jpg`)" class="img-fluid">
					</a>
				</div>
				<div>
					<a class="my-games" data-gall="game9" :href="require(`~/assets/images/features/game/game9.jpg`)">
						<img :src="require(`~/assets/images/features/game/game9.jpg`)" class="img-fluid">
					</a>
				</div>
				<div>
					<a class="my-games" data-gall="game10" :href="require(`~/assets/images/features/game/game10.jpg`)">
						<img :src="require(`~/assets/images/features/game/game10.jpg`)" class="img-fluid">
					</a>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default{
		mounted(){
			this.Carousel(),
			this.VenoBox()
		},

		methods:{
			Carousel(){
				tns({
					container: '.game',
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
			VenoBox(){
				new VenoBox({
					selector: '.my-games',
					numeration: true,
					infinigall: true,
					share: ['facebook', 'twitter', 'linkedin', 'pinterest', 'download'],
					spinner: 'rotating-plane'
				});
			}
		}
	}
</script>

<style>
	.my-games img{
		width: 900px;
	}
</style>