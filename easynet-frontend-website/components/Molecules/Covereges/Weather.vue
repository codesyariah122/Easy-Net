<template>
	<div>
		<!-- <pre>
			{{temp}}
		</pre> -->
		<div v-if="loading" class="d-flex justify-content-center">
			<div class="spinner-grow text-danger" role="status">
				<span class="visually-hidden">Loading...</span>
			</div>
		</div>
		<div v-else>
			<picture>
				<p><strong>Weather : </strong></p>

				<p>
					{{dt}}  <br> <span class="weather badge rounded-pill bg-light text-dark mt-3">{{city}}  - {{weather.main}} / {{weather.description}} <cite>{{getCelcius(temp)}} <sup>°C</sup></cite>  
						<img :src="`http://openweathermap.org/img/wn/${weather.icon}@2x.png`" width="50">
					</span>
				</p>
			</picture>
		</div>
		
	</div>
</template>

<script>
	export default{
		props:['city'],

		data(){
			return {
				loading: null,
				weather:{},
				dt: ''
			}
		},

		beforeMount(){
			this.WeatherCity(this.city)
		},

		methods:{
			WeatherCity(city){
				console.log(city)
				this.loading=true
				this.$axios.get(`${process.env.BASEURL}/weather-city/${city}/${process.env.APITOKEN}`)
				.then(res=>{
					// console.log(res.data)
					setTimeout(() => {
						this.loading=false
						this.temp=res.data.data.main.temp
						this.weather=res.data.data.weather[0]
						// const date = new Date(res.data.data.dt*1000).toLocaleString()
						this.dt = this.$moment(res.data.data.dt*1000).format("LLLL")
					}, 1000)
				})
			},
			getCelcius(num){
				num = parseFloat(num)
				return Math.ceil((num - 32) / 1.8)
			}
		}
	}
</script>

<style>
	.weather img{
		filter: drop-shadow(13px 13px 18px black);
	}
</style>