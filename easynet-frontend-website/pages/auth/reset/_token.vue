<template>
	<div>
		<ResetPassword />
	</div>
</template>

<script>
	import ResetPassword  from  '@/components/Auth/ResetPassword'

	export default{
		layout: 'auth',
		name: 'reset',
		components:{
			ResetPassword
		},
		head:{
			titleTemplate: 'EasyNet - Reset'
		},
	}
</script>