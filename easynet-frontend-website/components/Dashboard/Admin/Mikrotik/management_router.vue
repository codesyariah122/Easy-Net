<template>
	<div>
		<div class="col-lg-12 col-xs-12 col-sm-12">
			<h4>Mikrotik Routeros Manage</h4>
		</div>

		<div class="col-lg-12 col-xs-12 col-sm-12 mb-5">
			<div class="btn-group" role="group" aria-label="Basic mixed styles example">
				<button @click.prevent="AktivInput" type="button" class="btn btn-info rounded-pill">Command Manage</button>
				<button @click.prevent="AktivPing" type="button" class="btn btn-warning rounded-pill">Ping</button>
			</div>
		</div>

		<div class="col-lg-12 col-xs-12 col-sm-12 mb-5 mt-2">
			<div v-if="input">
				<form @submit.prevent="CommandRouter">
					<div class="form-group">
						<div class="mb-3">
							<label for="command" class="form-label">Routeros Command</label>
							<input type="text" class="form-control" id="command" placeholder="Router Command" v-model="command" name="command">
						</div>
					</div>
					<div class="form-group">
						<div class="d-grid gap-2">
							<button type="submit" class="btn btn-primary btn-sm rounded-pill">Enter Command</button>
						</div>
					</div>
				</form>
			</div>

			<div v-else>
				{{ping}}
			</div>
		</div>

		<div v-if="command_success" class="col-lg-12 col-xs-12 col-sm-12 mb-5 mt-2">
			<div v-if="loading">
				<div class="d-flex justify-content-center">
					<div class="spinner-grow text-info" role="status">
						<span class="visually-hidden">Loading...</span>
					</div>
				</div>
			</div>
			<div v-else>
				<pre>
					{{results}}
				</pre>
			</div>
		</div>

	</div>
</template>

<script>
	export default {
		data(){
			return {
				input: null,
				ping: null,
				loading: null,
				command: '',
				command_success: null,
				results: []
			}
		},

		methods: {
			AktivInput(){
				this.input = true
				this.ping = false
			},
			AktivPing(){
				this.ping = true
				this.input = false
			},

			CommandRouter(){
				this.$axios.post(`${process.env.BASEURL}/routeros-data`,{
					command: this.command
				})
				.then(res => {
					console.log(res.data)
					if(res.data.success){
						this.results = res.data.data
						this.command_success = res.data.success
					}
				})
				.catch(err => {
					console.log(err.message)
				})
			}
		}
	}
</script>