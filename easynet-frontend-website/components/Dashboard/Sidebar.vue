<template>
	<nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse" data-simplebar>
		<div class="sidebar-inner px-4 pt-3">
			<div class="user-card d-flex d-md-none align-items-center justify-content-between justify-content-md-center pb-4">
				<div class="d-flex align-items-center">
					<div class="avatar-lg me-4">
						<img src="/assets/dashboard/assets/img/team/profile-picture-3.jpg" class="card-img-top rounded-circle border-white"
						alt="Bonnie Green">
					</div>
					<div class="d-block">
						<h2 class="h5 mb-3">Hi, {{userdata.name}}</h2>
						<a @click.prevent="logout" href="#" class="btn btn-secondary btn-sm d-inline-flex align-items-center">
							<svg class="icon icon-xxs me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>            
							Sign Out
						</a>
					</div>
				</div>
				<div class="collapse-close d-md-none">
					<a href="#sidebarMenu" data-bs-toggle="collapse"
					data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="true"
					aria-label="Toggle navigation">
					<svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
				</a>
			</div>
		</div>
		
		<ul class="nav flex-column pt-3 pt-md-0">
			<li class="nav-item">
				<nuxt-link :to="`/dashboard/admin/${userdata.username}/`" class="nav-link d-flex align-items-center">
					<span class="sidebar-icon">
						<img src="/assets/dashboard/assets/img/brand/light.svg" height="20" width="20" alt="Volt Logo">
					</span>
					<span class="mt-1 ms-1 sidebar-text">EasyNet</span>
				</nuxt-link>
			</li>

			<li :class="`nav-item ${($route.path === `/dashboard/admin/${userdata.username}/`) ? 'active' : ''}`">
				<nuxt-link :to="`/dashboard/admin/${userdata.username}/`" class="nav-link">
					<span class="sidebar-icon">
						<i class="lni lni-dashboard"></i>
					</span> 
					<span class="sidebar-text">Dashboard</span>
				</nuxt-link>
			</li>
			<li v-if='userdata.roles != "[\"SALES\"]" && userdata.roles != "[\"SUPPORT\"]"' :class="`nav-item ${($route.path === `/dashboard/admin/${userdata.username}/users`) ? 'active' : ''}`">
				<nuxt-link :to="`/dashboard/admin/${userdata.username}/users`" class="nav-link d-flex justify-content-between">
					<span>
						<span class="sidebar-icon">
							<i class="lni lni-users"></i>
						</span>
						<span class="sidebar-text">Users</span>
					</span>
				</nuxt-link>
			</li>
			<li :class="`nav-item ${($route.path === `/dashboard/admin/${userdata.username}/contact`) ? 'active' : ''}`">
				<nuxt-link :to="`/dashboard/${roles}/${userdata.username}/contact`" class="nav-link">
					<span class="sidebar-icon">
						<i class="lni lni-book"></i>
					</span>
					<span class="sidebar-text">Contacts</span>
				</nuxt-link>
			</li>
			<li v-if='userdata.roles != "[\"SALES\"]" && userdata.roles != "[\"SUPPORT\"]"' :class="`nav-item ${($route.path === `/dashboard/admin/${userdata.username}/order`) ? 'active' : ''}`">
				<nuxt-link :to="`/dashboard/admin/${userdata.username}/order`" class="nav-link">
					<span class="sidebar-icon">
						<i class="lni lni-cart-full"></i>
					</span>
					<span class="sidebar-text">Order</span>
				</nuxt-link>
			</li>
			<li v-if='userdata.roles != "[\"SALES\"]" && userdata.roles != "[\"SUPPORT\"]"' :class="`nav-item ${($route.path === `/dashboard/admin/${userdata.username}/mikrotik`) ? 'active' : ''}`">
				<nuxt-link :to="`/dashboard/admin/${userdata.username}/mikrotik`" class="nav-link">
					<span class="sidebar-icon">
						<i class="lni lni-android"></i>
					</span>
					<span class="sidebar-text">Mikrotik</span>
				</nuxt-link>
			</li>
		</ul>
	</div>
</nav>
</template>

<script>
	export default{
		props: ['userdata', 'logout','route'],
		data(){
			return {
				roles: this.userdata.roles === "[\"ADMIN\"]" ? "admin" : this.userdata.roles === "[\"SALES\"]" ? "sales" : this.userdata.roles === "[\"SUPPORT\"]" ? "Support" : "Customer"
			}
		}
	}
</script>