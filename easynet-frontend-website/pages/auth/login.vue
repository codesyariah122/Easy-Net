<template>
	<div>
		<FormLogin/>
	</div>
</template>

<script>
	import FormLogin  from  '@/components/Auth/FormLogin'

	export default{
		layout: 'auth',
		components:{
			FormLogin
		},
		head:{
			titleTemplate: 'EasyNet - Login'
		},
	}
</script>