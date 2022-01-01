<template>
	<div>

		<!-- <pre>
			{{blog}}
		</pre> -->
		
		<div class="container mt-5">
			<div class="row">
				<div class="row justify-content-center">
					<div :class="`col-lg-12 col-xs-12 col-sm-12 ${isDevice ? 'mb-0' : 'mb-5'}`">
						<div class="d-grid gap-2">
							<a href="/#blog" class="btn btn-primary rounded-pill" type="button">Back Homepage</a>
						</div>
					</div>
				</div>
				<div class="col-lg-8 offset-lg-2 col-12">
					<div class="post-thumbnils">
						<img :src="require(`~/assets/blog/images/${blog.slug}/${blog.img}`)" alt="#" width="600">
						<div class="author">
							<!-- <img :src="blog.author.img" alt="#">  -->
							<span>
								By {{blog.author.name}}
							</span>
						</div>
					</div>
					<div class="post-details">
						<div class="detail-inner">
							<h2 class="post-title">
								<a href="#">
									{{blog.title}}
								</a>
							</h2>

							<ul class="custom-flex post-meta">
								<li>
									<a href="#">
										<i class="lni lni-calendar"></i>
										{{$moment(blog.createdAt).format("LLLL")}}
									</a>
								</li>
								<!-- <li>
									<a href="#">
										<i class="lni lni-comments"></i>
										35 Comments
									</a>
								</li>
								<li>
									<a href="#">
										<i class="lni lni-eye"></i>
										55 View
									</a>
								</li> -->
							</ul>
							<p>{{blog.detail}}</p>

							<div class="post-image">
								<div class="row">
									<div class="col-lg-6 col-md-6 col-12">
										<a href="#">
											<img class="blog-inner-big-img" src="assets/images/blog/blog-single-left.jpg" alt="#">
										</a>
									</div>
									<div class="col-lg-6 col-md-6 col-12">
										<a href="#" class="mb-4">
											<img src="assets/images/blog/blog-single2.jpeg" alt="#">
										</a>
										<a href="#">
											<img src="assets/images/blog/blog-single3.jpeg" alt="#">
										</a>
									</div>
								</div>
							</div>
							<nuxt-content :document="blog" style="text-align: justify; font-size: 18px;"/>

							<div class="post-tags-media mt-5 mb-5">
								<div class="post-tags popular-tag-widget mb-xl-40">
									<!-- <pre>
										{{tags}}
									</pre> -->
									<h5 class="tag-title">Related Tags</h5>
									<div v-for="(item,index) in tags" class="tags">
										<a href="#">
											{{item.name}}
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
							
						</div>
						<!-- <div class="comment-form">
							<h3 class="comment-reply-title">Leave a comment</h3>

						</div> -->
					</div>
				</div>
			</div>
		</div>

	</div>
</template>

<script>
	export default{
		layout: 'blog',
		data(){
			return {
				isDevice: this.$isMobile,
			}
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
	}
</script>