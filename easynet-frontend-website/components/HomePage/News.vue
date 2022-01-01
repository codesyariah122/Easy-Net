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
					<div v-for="(item, index) in blogs" class="col-lg-6 col-md-6 col-12 mb-5">
						<div class="single-news wow fadeInUp" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
								<div class="image">
									<img class="thumb" :src="require(`~/assets/blog/images/${item.slug}/${item.img}`)" alt="#">
									<div class="meta-details">
										<img :src="item.author.img" alt="#"> <span>BY {{item.author.name}}</span>
									</div>
								</div>
								<div class="content-body">
									<h4 class="title">
										<nuxt-link :to="{name: `blog-slug`, params: {slug: item.slug}}">{{item.title}}</nuxt-link>
									</h4>
									<p>{{item.description}}</p>
								</div>
							</div>
						</div>
					</div>
					<br><br>
					<div class="row justify-content-center mt-5 mb-2">
						<div class="col-lg-12 col-xs-12 col-sm-12">
							<div class="d-grid gap-2">
								<button class="btn btn-primary rounded-pill btn-sm" type="button">Load More</button>
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
		props: ['blogs']
	}
</script>