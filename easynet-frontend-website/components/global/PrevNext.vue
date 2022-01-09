<template>
	<div>
		<h5 class="text-secondary text-center">Article Lainnya</h5>
		<div class="d-flex justify-content-center">
			<div class="col-md-4">	
				<div v-if="prev" class="card card-prev-next mx-auto mt-3 mb-3" style="width: 18rem;">
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
			</div>

			<div class="col-md-4">
				<div v-if="next" class="card card-prev-next ml-5 mt-3 mb-3" style="width: 18rem;">
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
		}
	}
</script>