<template>
	<div>
		<header class="relative z-50 w-full h-24">
			<div
			class="container flex items-center justify-center h-full max-w-6xl px-8 mx-auto sm:justify-between xl:px-0">

				<a href="/" class="relative flex items-center inline-block h-5 h-full font-black leading-none">
					<EasynetLogo/>
				</a>
				<!-- <pre>
					{{show_menu}}
				</pre> -->
				<nav id="nav" class="absolute top-0 left-0 z-50 flex flex-col items-center justify-between hidden w-full h-64 pt-5 mt-24 text-sm text-gray-800 bg-white border-t border-gray-200 md:w-auto md:flex-row md:h-24 lg:text-base md:bg-transparent md:mt-0 md:border-none md:py-0 md:flex md:relative">
						<a href="#"
						class="ml-0 mr-0 font-bold duration-100 md:ml-12 md:mr-3 lg:mr-8 transition-color hover:text-indigo-600">Home</a>
						<a href="#features"
						class="mr-0 font-bold duration-100 md:mr-3 lg:mr-8 transition-color hover:text-indigo-600">Features</a>
						<a href="#pricing"
						class="mr-0 font-bold duration-100 md:mr-3 lg:mr-8 transition-color hover:text-indigo-600">Pricing</a>
						<a href="#testimonials"
						class="font-bold duration-100 transition-color hover:text-indigo-600">Testimonials</a>
						<div class="flex flex-col block w-full font-medium border-t border-gray-200 md:hidden">
							<a href="#_" class="w-full py-2 font-bold text-center text-pink-500">Login</a>
							<a href="#_"
							class="relative inline-block w-full px-5 py-3 text-sm leading-none text-center text-white bg-indigo-700 fold-bold">Get
						Started</a>
					</div>
				</nav>
				<nav v-if="show_menu" id="nav" 
				:class="`${show_menu ? 'close' : 'hidden'} absolute top-0 left-0 z-50 flex flex-col items-center justify-between w-full h-64 pt-5 mt-24 text-sm text-gray-800 bg-white border-t border-gray-200 md:w-auto md:flex-row md:h-24 lg:text-base md:bg-transparent md:mt-0 md:border-none md:py-0 md:flex md:relative`">
						<a href="#"
						class="ml-0 mr-0 font-bold duration-100 md:ml-12 md:mr-3 lg:mr-8 transition-color hover:text-indigo-600">Home</a>
						<a href="#features"
						class="mr-0 font-bold duration-100 md:mr-3 lg:mr-8 transition-color hover:text-indigo-600">Features</a>
						<a href="#pricing"
						class="mr-0 font-bold duration-100 md:mr-3 lg:mr-8 transition-color hover:text-indigo-600">Pricing</a>
						<a href="#testimonials"
						class="font-bold duration-100 transition-color hover:text-indigo-600">Testimonials</a>
						<div class="flex flex-col block w-full font-medium border-t border-gray-200 md:hidden">
							<a href="#_" class="w-full py-2 font-bold text-center text-pink-500">Login</a>
							<a href="#_"
							class="relative inline-block w-full px-5 py-3 text-sm leading-none text-center text-white bg-indigo-700 fold-bold">Get
						Started</a>
					</div>
				</nav>

				<Rectangle/>

				<div id="nav-mobile-btn" @click="showMenu"
					:class="`absolute top-0 right-0 z-50 block w-6 mt-8 mr-10 cursor-pointer select-none md:hidden sm:mt-10 ${show_menu ? 'close' : ''}`">
					<span class="block w-full h-1 mt-2 duration-200 transform bg-gray-800 rounded-full sm:mt-1"></span>
					<span class="block w-full h-1 mt-1 duration-200 transform bg-gray-800 rounded-full"></span>
				</div>
			</div>
		</header>
		<!-- End Header Section-->

		<ColorModePicker class="ml-8"/>

		<!-- BEGIN HERO SECTION -->
			<Hero :loading="loading" :herodata="herodata"/>
		<!-- HERO SECTION END -->

		<!-- <pre>
			{{herodata}}
		</pre> -->

	</div>
</template>

<script>
	import Hero from '@/components/Layouts/partials/Hero'
	import EasynetLogo from  '@/components/Layouts/partials/easynet-logo'
	import ColorModePicker from '@/components/ColorModePicker'

	export default{
		components:{
			Hero,
			Rectangle,
			EasynetLogo,
			ColorModePicker
		},
		data(){
			return {
				herodata: {},
				show_menu: null,
				loading: null
			}
		},
		mounted(){
			this.getHeroData()
		},

		methods:{
			getHeroData(){
				this.loading=true
				const data = {
					token: process.env.APITOKEN,
					baseurl: process.env.BASEURL
				}
				this.$axios.get(`${data.baseurl}/webdata/${data.token}`)
				.then(res => {
					// console.log(res.data.data)
					setTimeout(() => {
						this.loading=false
						this.herodata = res.data.data
					}, 1500)
				})
				.catch(err => {
					console.log(err.response)
				})
			},
			showMenu(){
				this.show_menu = !this.show_menu
			},
			closeMenu(){
				this.show_menu = !this.show_menu
			}
		}
	}
</script>