<template>
	<div class="page-wrapper toggled light-theme">
		
		<!-- Partial -->
		<Navigation/>

		<!-- Main Content -->
		<MainContent :event="event" :you="you" :loading="loading"/>

	</div>
</template>

<script>
	import Navigation from '../../components/Partials/Navigation'
	import MainContent from '../../components/Contents/MainContent'

	export default {
		components:{
			Navigation,
			MainContent
		},
		data(){
			return {
				ip:'',
				event:{
					notifdata:{}
				},
				you: {},
				loading: null
			}
		},

		beforeMount(){
			this.getIp()
		},


		mounted() {
			this.storeVisitor(this.ip),
			this.notification()
		},

		methods: {
			getIp(){
				this.axios.get('https://api.ipify.org/?format=json')
				.then(res => {
					this.ip = res.data.ip
				})
				.catch(err => {
					console.log(err.message)
				})
			},

			storeVisitor(ip){
				this.loading=true
				const config = {
					api_url: process.env.MIX_API_URL,
					api_key: process.env.MIX_APP_API_KEY
				}
				this.axios
				.post(`${config.api_url}/store/visitor/${config.api_key}`, {
					ip: ip
				})
				.then(res => {
					// console.log(res.data)
					this.loading=false
					this.you = res.data.data
				})
				.catch(err => {
					this.loading=false
					console.log(err.message)
				})
			},

			notification(){
				this.$echo.channel('notification').listen('NotificationEvent', (payload) => {
					// alert("Subscribe success")
					// console.log(payload.data);
					this.event.notifdata = payload.data
				});
			},
		}
	}
</script>