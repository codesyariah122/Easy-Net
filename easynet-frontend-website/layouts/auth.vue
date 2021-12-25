<template>
	<div>
		<!-- <Header/> -->
		<Nuxt/>
	</div>
</template>

<script>

	export default{
		name: 'auth',
		head:{
			meta: [
				{ charset: 'utf-8' },
				{ name: 'viewport', content: 'width=device-width, initial-scale=1' },

	     
	      		{ hid: 'description', name: 'description', content: 'Meta description' }
	      	],
	      	link: [
		      	{
		      		hid: "canonical",
		      		rel: "canonical",
		      		href: "https://easynet.id/auth/login",
		      	},
		      	{ 
		      		rel: 'stylesheet', 
		      		type: 'text/css', 
		      		href: '/assets/auth/fonts/material-icon/css/material-design-iconic-font.min.css'
		      	},
		      	{ 
		      		rel: 'stylesheet', 
		      		type: 'text/css', 
		      		href: '/assets/auth/css/style.css'
		      	},
	      	],
	      	script: [
		      	{
		      		src:'/assets/auth/vendor/jquery/jquery.min.js',
		      		type: 'text/javascript'
		      	},
		      	{
		      		src: '/assets/auth/js/main.js',
		      		type: 'text/javascript'
		      	},
	      	],
		},
		mounted(){
			$crisp.push(['do', 'chat:hide'])
		}
	}
</script>

