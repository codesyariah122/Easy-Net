<template>
	<div class="page-wrapper toggled light-theme">
		
		<!-- Partial -->
		<Navigation/>

		<!-- Main Content -->
		<MainContent :event="event" :ip="ip"/>

	</div>
</template>

<script>
	import Navigation from '../../components/Partials/Navigation'
	import MainContent from '../../components/Contents/MainContent'

	export default {
		props: ['appName'],
		components:{
			Navigation,
			MainContent
		},
		data(){
			return {
				ip:'',
				event:{
					notifdata:{}
				}
			}
		},

		beforeMount() {
			this.getIp()
		},

		methods: {
			getIp(){
				this.axios('https://api.ipify.org/?format=json')
				.then(res=>{
					console.log(res)
				})
			},
			notification(){
				this.$echo.channel('notification').listen('NotificationEvent', (payload) => {
					// alert("Subscribe success")
					console.log(payload.data);
					this.event.notifdata = payload.data
				});
			},
		}
	}
</script>