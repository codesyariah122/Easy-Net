<template>
	<div>

		<!-- <pre>
			{{blog}}
		</pre> -->
		
		<div class="row justify-content-center mt-5">
			<div :class="`col-lg-12 col-xs-12 col-sm-12 ${isDevice ? 'mb-0' : 'mb-5'}`">
				<div class="d-grid gap-2">
					<a @click="$colorMode.preference = 'light'" href="/#blog" class="btn btn-primary rounded-pill" type="button">
						<i class="lni lni-angle-double-left"></i> Back Homepage
					</a>
					</div>
				</div>
				<div class="col-lg-12 col-xs-12 col-sm-12">
					<div class="float-right">
						<ColorModePicker/>
					</div>
				</div>
			</div>

			<div class="row justify-content-center">
				<div class="single-news wow fadeInUp col-lg-12 col-xs-12 col-sm-12">
					<div class="image">
						<img class="thumb img-fluid" :src="require(`~/assets/blog/images/${blog.slug}/${blog.img}`)" alt="#">
						<div class="meta-details text-capitalize">
							<!-- <img :src="blog.author.img" alt="#">  -->
							<span>BY {{blog.author.name}}</span>
						</div>
					</div>

				</div>

				<div class="post-content col-lg-12 col-xs-12 col-sm-12">
					<div class="post-details">
						<div class="detail-inner">
							<div class="row justify-content-center">
								<div class="col-lg-12 col-xs-12 col-sm-12">
									<h2 class="post-title text-center">
										<a href="#">
											{{blog.title}}
										</a>
									</h2>
								</div>

								<div class="col-md-10 col-xs-10 col-sm-10">
									<ul class="custom-flex post-meta">
										<li>
											<a href="#">
												<i class="lni lni-calendar"></i>
												{{$moment(blog.createdAt).format("LLLL")}}
											</a>
										</li>

									</ul>
									<p>{{blog.detail}}</p>

									<nuxt-content :document="blog" style="text-align: justify; font-size: 18px;"/>

									<div class="post-tags-media mt-5 mb-5">
										<div class="post-tags popular-tag-widget mb-xl-40">
											<!-- <pre>
												{{tags}}
											</pre> -->
											<h5 class="tag-title">Related Tags</h5>
											<div v-for="(item,index) in tags" class="tags">
												<a href="#" class="text-primary">
													#{{item.name}}
												</a>
											</div>
										</div>
										<div class="post-social-media">
											<h5 class="share-title">Social Share</h5>
											<ul class="custom-flex">
												<li>
													<a href="#">
														<i class="lni lni-twitter-original"></i>
													</a>
												</li>
												<li>
													<a href="#">
														<i class="lni lni-facebook-oval"></i>
													</a>
												</li>
												<li>
													<a href="#">
														<i class="lni lni-instagram"></i>
													</a>
												</li>
											</ul>
										</div>
									</div>
								</div>

								<div class="post-comments  mt-3 mb-5">
									<h3 class="comment-title">Post comments</h3>
									<client-only>
										<Disqus/>
									</client-only>
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
	import ColorModePicker from '@/components/ColorModePicker'

	export default{
		layout: 'blog',
		components: {
			ColorModePicker
		},
		data(){
			return {
				isDevice: this.$isMobile ? true : false
			}
		},
		head:{
			titleTemplate: `EasyNet::Blog `
		},
		async asyncData({ $content, params }) {
			const blog = await $content('Blog', params.slug).fetch();
			const tagsList = await $content('tags')
			.only(['name', 'slug'])
			.where({ name: { $containsAny: blog.tags } })
			.fetch()
			const tags = Object.assign({}, ...tagsList.map((s) => ({ [s.name]: s })))
			return {
				blog,
				tags
			}
		},

		methods: {
			BackHome(){
				const color_mode = document.querySelector('.dark-mode')
				this.$swal(color_mode)
			}
		}
	}
</script>

<style>
	.nuxt-content{
		width: 90%;
		margin-left: 1rem;
		align-content: center;
	}
</style>