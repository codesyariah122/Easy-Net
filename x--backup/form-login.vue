<div class="container">
			<div class="row mt-5">
				<div class="spContainer mx-auto">
					<div class="card px-4 py-3 border-0 shadow">
						<div class="d-inline text-left mb-3">
							<div class="justify-content-center col-lg-12 col-xs-12 col-sm-12">
								<nuxt-link to='/' aria-label="Easynet" class="z-10 mt-0 mb-30 absolute md:ml-12 mb-20">
									<img :src="require('~/assets/logo/easynet_logo.svg')" alt="Logo" height="70" />
								</nuxt-link>
							</div>
							<h3 class="font-weight-bold">Login</h3>
							<p>Easy Net (Internet Service Providers)</p>

							<div v-if="error_login">
								<div class="alert alert-danger" role="alert">
									<p class="text-warning">User not found</p>
									<p>{{data_error_login}}</p>
								</div>
							</div>

							<div v-if="loginFailed" >				
								<div class="alert alert-warning" role="alert">
									<p class="text-danger">Login Failed</p>
									<p>{{failed}}</p>
								</div>
							</div>
						</div>
						<form @submit.prevent="login">
							<div class="d-inline text-center mb-30">
								<div class="form-group mx-auto">
									<input id="email" class="form-control inpSp" type="text" placeholder="your_email@email.com" autofocus v-model="user.email">
									<div class="text-danger mt-10" v-if="validation.email">
										{{validation.email[0]}}
									</div><br>
								</div>
							</div>
							<div class="d-inline text-center mb-30">
								<div class="form-group mx-auto">
									<input id="password" class="form-control inpSp" type="password" placeholder="Password" v-model="user.password">
								</div>
								<div class="mt-10 text-danger" v-if="validation.password">
									{{validation.password[0]}}
								</div>
							</div>
							<div class="inline text-center mb-30">
								<div class="form-group">
									<a class="small text-black-50 pl-2 ml-2 border-left" href="">Forgot Password ?</a>
								</div>
							</div>
							<div class="d-inline text-left mb-10">
								<div class="form-group mx-auto d-grid gap-2">
									<button class="btn btn-primary rounded-pill" type="submit">
										<div v-if="loading">
											<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
											<span class="visually-hidden">Loading...</span>				
										</div>
										<div v-else>
											Login
										</div>
									</button>
								</div>
							</div>
							<div class="d-inline text-left mb-30 ml-10">
								<div class="form-group mx-auto">
									<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
									<label class="form-check-label" for="flexCheckDefault">
										Remember!
									</label>
								</div>
							</div>
						</form>
						
						<div class="d-inline text-left mb-1">
							<div class="form-group mx-auto mb-0">
								<label class="text-black-50 small">or login with</label>
							</div>
						</div>
						<div class="d-inline text-left">
							<div class="form-group mx-auto d-grid gap-2">
								<button type="button" class="btn btn-sm btn-danger rounded-pill"> <span class="badge text-white"><i class="lni lni-google"></i></span>
									Google
								</button>
								<!-- <button type="button" class="btn btn-sm btn-light ml-2"> <span class="badge text-white"><i class="fab fa-facebook-f text-primary"></i></span>
									Facebook
								</button> -->
							</div>
						</div>
						<div class="d-inline text-left mt-3">
							<div class="form-group mx-auto mb-0">
								<a class="text-black font-weight-bold regStr" href="#">Register new account</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>