<template>
	<div>
		<Nuxt :key="$route.fullPath"/>

		<!-- <Footer/> -->
	</div>
</template>

<script>
	import Footer from '@/components/Layouts/Footer'

	export default{
		name: 'profile',
		components:{
			Footer
		},

		head:{
			link: [
				{ rel: 'stylesheet', type: 'text/css', href: '/assets/css/main.css'},
				{ rel: 'stylesheet', type: 'text/css', href: '/assets/profile/css/style.css'},
				{ rel: 'stylesheet', type: 'text/css', href: 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'}
			],

			script: [
				{
					src: 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js',
					type: 'text/javascript'
				},
				{
					src: 'https://widget.tochat.be/bundle.js?key=89ae7aff-d3ec-425e-ad9e-a4049e3f5796',
					defer: true
				}
			]
		},

		mounted(){
			$crisp.push(['do', 'chat:show']);
		},

	}
</script>