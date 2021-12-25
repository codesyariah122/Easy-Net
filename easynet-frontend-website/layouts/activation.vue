<template>
	<div>
		<!-- <Header/> -->
		<Nuxt/>
		<!-- <a href="#" class="scroll-top btn-hover">
			<i class="lni lni-chevron-up"></i>
		</a> -->
		<Footer/>
	</div>
</template>

<script>
	import Footer from '@/components/Layouts/Footer'

	export default{
		name: 'activation',
		components:{
			Footer
		},

		head:{
			link: [
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

		mounted(){
			$crisp.push(['do', 'chat:hide'])
			// document.querySelector('.svelte-x8mclh').style.display="none",
			// document.querySelector('.mbutton').style.display="none"
		}
	}
</script>

