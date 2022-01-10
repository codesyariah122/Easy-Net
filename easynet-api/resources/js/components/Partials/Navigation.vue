<template>
	<div>
		<nav id="sidebar" class="sidebar-wrapper">
			<div class="sidebar-content">
				<!-- sidebar-brand  -->
				<div class="sidebar-item sidebar-brand text-white font-weight-bold">
					{{app_name}}
				</div>
				<!-- sidebar-header  -->
				<!-- sidebar-search  -->
				<div class="sidebar-item sidebar-search">
					<div>
						<div class="input-group">
							<input type="text" class="form-control search-menu" placeholder="Search...">
							<div class="input-group-append"> <span class="input-group-text">
								<i class="fa fa-search" aria-hidden="true"></i>
							</span> </div>
						</div>
					</div>
				</div>
				<!-- sidebar-menu  -->
				<div class=" sidebar-item sidebar-menu">
					<ul>
						<li class="header-menu"> <span>Extra</span> </li>
						<li class="sidebar-dropdown">
							<a href="#"> <i class="fa fa-shopping-cart"></i> 
								<span class="menu-text">Getting Started</span>  
							</a>
							<div class="sidebar-submenu">
								<ul>
									<li> <a href="#">Setup home page layout

									</a> </li>
									<li> <a href="#">How do i add knowledgebase post</a> </li>
									<li> <a href="#">How do i change header navigation style globally</a> </li>
								</ul>
							</div>
						</li>
						<li>
							<a href="#"> <i class="fa fa-book"></i> <span class="menu-text">Basic Usage</span> </a>
						</li>
					</ul>
				</div>
				<!-- sidebar-menu  -->
			</div>
			<!-- sidebar-footer  -->
			<div class="sidebar-footer">
				<div>
					<a id="pin-sidebar" href="#"> <i class="fa fa-power-off"></i> </a>
				</div>
				<div class="pinned-footer">
					<a href="#"> <i class="fas fa-ellipsis-h"></i> </a>
				</div>
			</div>
		</nav>
	</div>
</template>

<script>
	export default {
		data(){
			return {
				app_name: 'EasyNet::Websites'
			}
		}
	}
</script>