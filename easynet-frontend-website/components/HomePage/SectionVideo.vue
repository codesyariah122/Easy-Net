<template>
	<div>
		<section class="intro-video-area overlay section">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="section-title white-text">
							<span class="wow fadeInDown" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInDown;">
								{{content.summary}}
							</span>
							<h2 class="wow fadeInUp" data-wow-delay=".4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">
								{{content.heading}}
							</h2>
							<!-- <pre>
								{{herodata.videoHeader}}
							</pre> -->
							<p class="wow fadeInUp" data-wow-delay=".6s" style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInUp;" v-html="content.paragraph">
							</p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="intro-video-play">
							<div class="row justify-content-center">
								<div class="col-lg-10 col-12">
									<div class="play-thumb wow zoomIn" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: zoomIn;">
										<a @click="LightBox" style='cursor: pointer;' class="glightbox video"><i class="lni lni-play"></i></a>
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
		data(){
			return{
				content:{
					summary: 'High Speed Internet Services Provider',
					heading: 'Segera pasang easynet sebagai partner provider handal yang dapat memenuhi kebutuhan internet anda',
					paragraph: 'Rasakan pengalaman  menakjubkan dengan berlangganan paket HighSpeed internet dari <span class="text-info">Easy Net</span>.',
					videoSection: `${process.env.APPURL}public/video/video2.mp4` 
				}
			}
		},
		methods:{
            LightBox(){
                GLightbox({
                    'href': this.content.videoSection,
                    'type': 'video',
                    'source': 'local', //vimeo, youtube or local
                    'width': 800,
                    'autoplayVideos': true,
                });
            },
        }
	}
</script>