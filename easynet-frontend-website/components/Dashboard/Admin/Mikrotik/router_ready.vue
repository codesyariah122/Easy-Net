<template>
	<div>
		<div class="col-lg-12 col-xs-12 col-sm-12 mb-2">
			<div class="alert alert-success" role="alert">
				{{message}}
			</div>
		</div>

		<!-- <pre>
			{{router_ready}}
		</pre> -->

		<div v-for="router in router_ready" class="col-lg-12 col-xs-12 col-sm-12 mb-3">
			<div class="card" style="width: 18rem;">
				<div class="card-body">
					<h5 class="card-title">
						<span :class="`badge ${router.connect ? 'bg-success' : 'bg-danger'}`">
							{{router.connect ? 'Connect' : 'Not-Connect'}}
						</span> :: {{router.identity}}
					</h5>
					<p class="card-text">
						IP Address :  <cite>{{router.ip}}</cite> <br>
						Username :  <cite>{{router.user}}</cite>
					</p>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props: ['router_ready', 'message']
	}
</script>