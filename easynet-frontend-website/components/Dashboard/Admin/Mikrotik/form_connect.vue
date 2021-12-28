<template>
	<div>
		<div class="col-lg-12 col-xs-12 col-sm-12 mb-3">
			<form @submit.prevent="ConnectRouter">
				<div class="form-group">
					<div class="mb-3">
						<label for="ip" class="form-label">Router Gateway</label>
						<input type="text" class="form-control" id="ip" placeholder="111.11.111.1" v-model="mikrotik.ip">
					</div>
				</div>
				<div class="form-group">
					<div class="mb-3">
						<label for="user" class="form-label">User Router</label>
						<input type="text" class="form-control" id="user" placeholder="Router_admin" v-model="mikrotik.user">
					</div>
				</div>
				<div class="form-group">
					<div class="mb-3">
						<label for="password" class="form-label">Router Password</label>
						<input type="text" class="form-control" id="password" placeholder="xxxxxxx" v-model="mikrotik.password">
					</div>
				</div>
				<div class="form-group">
					<div class="mb-3">
						<div class="d-grid gap-2">
							<button type="submit" class="btn btn-primary btn-sm rounded-pill">
								<div v-if="loading">
									<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
									Loading...
								</div>
								<div v-else>
									Submit
								</div>
							</button>
						</div>
					</div>
				</div>
			</form>
		</div>

		<div class="col-lg-12 col-xs-12 col-sm-12 mt-2">
			<div v-if="loading">
				<center>
					<div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
						<span class="visually-hidden">Loading...</span>
					</div>
				</center>
			</div>
			<div v-else>
				<div v-if="show">
					<div class="alert bg-info text-white rounded-pill" v-if="success">
						{{message}}
					</div>
					<div class="alert bg-warning text-white rounded-pill" v-else>
						{{not_found}}
					</div> 
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default{
		props: ['mikrotik', 'ConnectRouter', 'loading', 'success', 'message', 'not_found', 'show']
	}
</script>