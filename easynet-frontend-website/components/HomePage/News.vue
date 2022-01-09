<template>
	<div>

		<!-- <pre>
			{{blogs}}
		</pre> -->

		<div id="blog" class="latest-news-area section mt-5">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="section-title">
							<span class="wow fadeInDown" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInDown;">latest news</span>
							<h2 class="wow fadeInUp" data-wow-delay=".4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">Latest News &amp; Blog</h2>
							<p class="wow fadeInUp" data-wow-delay=".6s" style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInUp;">Kumpulan article, tips and trick dan berbagai informasi terupdate seputar informasi teknologi dan jaringan internet.</p>
						</div>
					</div>
				</div>
				<div class="row  mb-5">

					<!-- <div v-if="postIndex < blogs.length" v-for="postIndex in postToShow">
						{{blogs[postIndex-1].title}}
					</div> -->

					<div v-if="postIndex <= blogs.length" v-for="postIndex in postToShow" class="col-lg-6 col-md-6 col-12">

						<div class="single-news wow fadeInUp" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
								<div class="image">
									<img class="thumb" :src="require(`~/assets/blog/images/${blogs[postIndex-1].slug}/${blogs[postIndex-1].img}`)" alt="#">
									<div class="meta-details">
										<img :src="blogs[postIndex-1].author.img" alt="#"> <span>BY {{blogs[postIndex-1].author.name}}</span>
									</div>
								</div>
								<div class="content-body">
									<h4 class="title">
										<nuxt-link :to="{name: `blog-slug`, params: {slug: blogs[postIndex-1].slug}}">{{blogs[postIndex-1].title}}</nuxt-link>
									</h4>
									<p>{{blogs[postIndex-1].description}}</p>
								</div>
							</div>
						</div>
						<div v-if="loading">
							<div class="text-center">
								<div style="width: 3rem; height: 3rem;" class="spinner-grow text-primary" role="status">
									<span class="visually-hidden">Loading...</span>
								</div>
							</div>
						</div>
					</div>
					<br><br>
					<div v-if="postToShow <= blogs.length || blogs.length > postToShow" class="row justify-content-center mb-2">
						<div class="col-lg-12 col-xs-12 col-sm-12">
							<div class="d-grid gap-2">
								<button @click="ShowPost" class="btn btn-primary rounded-pill btn-sm" type="button">
									<div v-if="loading">
										<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
										Loading...
									</div>
									<span v-else>
										Load More ...
									</span>
								</button>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</template>


<script>
	export default{
		props: ['blogs'],
		data(){
			return {
				postToShow:2,
				loading: null
			}
		},

		methods:{
			ShowPost(){
				this.loading=true

				setTimeout(() => {
					this.loading=false
					this.postToShow+=2
				},1500)

			}
		}
	}
</script>