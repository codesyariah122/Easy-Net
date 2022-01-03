<template>
	<div>
		<!-- <pre>
			{{userdata}}
		</pre> -->
		<div class="container mt-4 mb-4 p-3 d-flex justify-content-center">
			<div class="card p-4">
				<div class="image d-flex flex-column justify-content-center align-items-center"> 
					<button class="btn btn-secondary"> 
						<!-- <img src="https://i.imgur.com/wvxPV9S.png" height="100" width="100" /> -->
						<img v-if="userdata.gender === 'MALE'" src="/assets/images/profile/male.svg" height="120" width="100" class="rounded-pill">
						<img v-else-if="userdata.gender === 'FEMALE'" src="/assets/images/profile/female.svg" height="120" width="100" class="rounded-pill">
						<img v-else src="/assets/images/profile/default.svg" height="100" width="100" />

					</button> 
					<span class="name mt-3">{{ userdata.name }}</span> 
					<span class="idd">@{{ userdata.username }}</span>
					<div class="idd mt-3">
						<span class="idd1 text-token">
							<strong>Token Authentication : </strong> <br>
							{{auth.token}}
						</span> <span><i class="fa fa-copy"></i></span> 
					</div>
					<div class="d-flex flex-row justify-content-center align-items-center mt-3"> <span class="number">0 <span class="follow">Orders</span></span> </div>
					<div class=" d-flex mt-2">
						<button @click.prevent="$emit('logout')" class="btn1 btn-dark">Logout</button>
						<button @click.prevent="EditProfile(userdata.id)" class="btn1 btn-dark">Edit Profile</button> 
					</div>
					<div class="text mt-3"> 
						<span>Eleanor Pena is a creator of minimalistic x bold graphics and digital artwork.<br><br> Artist/ Creative Director by Day #NFT minting@ with FND night. </span> 
					</div>
					
					<div class=" px-2 rounded mt-4 date "> 
						<span class="join">Join at {{$moment(userdata.created_at).tz("Asia/Jakarta").format("LLLL")}}</span> 
					</div>
				</div>
				<div class="mt-5 mb-5 d-flex flex-row justify-content-center align-items-center mt-3">
					<div class="col-lg-12 col-xs-12 col-sm-12">
						<center>
							<a  href="/" class="btn1 btn btn-primary rounded-pill">
								<i class="lni lni-home"></i> Home
							</a>
						</center>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</template>

<script>
	export default{
		props: ['userdata', 'auth', 'path'],

		beforeMount(){
			$crisp.push(['do', 'chat:open'])
		},
		mounted(){
			this.ChatOpen(this.auth)
		},

		methods: {
			ChatOpen(user){
				// console.log(user)
				$crisp.push(["set", "user:email", user.email])
				$crisp.push(["set", "user:nickname", user.name])
				// $crisp.push(["set", "session:data", [
				// 	["user_id", user.id],
				// 	["username", user.username],
				// 	["fullname", user.name],
				// 	["email", user.email]
				// ]])
		    },
		    EditProfile(id){
		    	this.$router.push({
		    		path: `${this.$route.path}/edit/${id}`
		    	})
		    }
		},

		filters: {
			FromNow(val){
				this.$moment(val, "YYYY-MM-DD").fromNow()
			}
		}
	}
</script>