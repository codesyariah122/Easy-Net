<template>
	<div>
		<!-- page-content  -->
		<main class="page-content">
			<div id="overlay" class="overlay"></div>
			<div class="container-fluid">
				<div class="row d-flex align-items-center p-3 border-bottom">
					<div class="col-md-1">
						<a id="toggle-sidebar" class="btn rounded-0 p-3" href="#"> <i class="fas fa-bars"></i> </a>
					</div>
					<div class="col-md-8">
						<nav aria-label="breadcrumb" class="align-items-center">
							<a href="index.html" class="breadcrumb-back" title="Back"></a>
							<ol class="breadcrumb d-none d-lg-inline-flex m-0">
								<li class="breadcrumb-item"><a href="index.html">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Docs</li>
							</ol>
						</nav>
					</div>
					<div class="col-md-3 text-left"> <a :href="repo" class="btn btn-sm btn-primary btn-rounded">Free Download</a> </div>
				</div>
				<div class="row p-lg-4">
					<h1 class="mb-2 mt-3">Introduction</h1>

					<pre>
						{{ip}}
					</pre>

					<article class="main-content col-md-9 pr-lg-5">
						<cite>Database Seeder </cite> <br>
						<code class="language-markup">
							$this->call(Administratorseeder::class);
						</code>	
						<br>
						<cite>Setup Project</cite> <br>
						<code class="language-markup">
							cd Easy-Net/ <br>
							cd easynet-api/ <br>
							cp .env.example .env <br>
							//Setup .env for your local machine <br>
							composer install <br>
							composer require laravel/ui <br>
							php artisan ui vue <br>
							npm install && npm run dev <br>
						</code>
						<br>

						<cite>Install Passport</cite> <br>
						<code class="language-markup">
							composer require laravel/passport
							php artisan migrate --seed
							php artisan passport:install
						</code>
						<br>
					</article>
				</div>
			</div>
		</main>
		<!-- end page-content" -->
	</div>
</template>

<script>
	export default {
		props: ['event', 'ip'],
		data(){
			return {
				repo: 'https://github.com/codesyariah122/Easy-Net'
			}
		}
	}
</script>

<style>
code {
	display: block;
	white-space: pre-wrap   
}
</style>