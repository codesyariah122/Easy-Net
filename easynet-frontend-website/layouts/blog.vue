<template>
	<div>
				
		<Nuxt/>

		<Footer />

		<a href="#" class="scroll-top btn-hover">
			<i class="lni lni-chevron-up"></i>
		</a>

	</div>
</template>

<script>
	import Footer from '@/components/Layouts/Footer'

	export default{
		components: {
			Footer
		},

		head:{
			link: [
			{ rel: 'stylesheet', type: 'text/css', href: require('~/assets/css/main.css')},
			// { rel: 'stylesheet', type: 'text/css', href: '/assets/css/blog.css'},
			{ rel: 'stylesheet', type: 'text/css', href: '/assets/css/main.css'},
			{ rel: 'stylesheet', type: 'text/css', href: '/assets/css/new-style.css'}
			],

			script: [
			{
				src: '/assets/js/main.js',
				type: 'text/javascript'
			},
			{
				src: 'https://widget.tochat.be/bundle.js?key=89ae7aff-d3ec-425e-ad9e-a4049e3f5796',
				defer: true
			}
			]
		},


	}
</script>
