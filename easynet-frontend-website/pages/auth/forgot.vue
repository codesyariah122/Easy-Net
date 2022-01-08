<template>
	<div>
		<ForgotPassword/>
	</div>
</template>

<script>
	import ForgotPassword  from  '@/components/Auth/ForgotPassword'

	export default{
		layout: 'auth',
		name: 'forgot',
		components:{
			ForgotPassword
		},
		head:{
			titleTemplate: 'EasyNet - Forgot'
		},
	}
</script>