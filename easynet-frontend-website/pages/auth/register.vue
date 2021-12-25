<template>
	<div>
		<FormRegister/>
	</div>
</template>

<script>
	import FormRegister from '@/components/Auth/FormRegister'

	export default{
		layout: 'auth',
		components:{
			FormRegister
		},
		head:{
			titleTemplate: 'EasyNet - Register'
		},
	}
</script>