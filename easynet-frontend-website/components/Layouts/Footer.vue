<template>
	<div>
		<footer class="footer">

            <div class="footer-middle">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-12">

                            <div class="f-about single-footer">
                                <div class="logo">
                                    <nuxt-link  to="/">
                                        <img src="/assets/images/logo/logo-blue.svg" alt="Logo">
                                    </nuxt-link>
                                </div>
                                <p>Layanan Dan Jasa Jaringan Internet High Performance</p>
                                <div class="footer-social">
                                    <ul>
                                        <li><a href="#"><i class="lni lni-instagram"></i></a></li>
                                        <li><a href="#"><i class="lni lni-twitter"></i></a></li>
                                        <li><a href="#"><i class="lni lni-linkedin"></i></a></li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-3 col-md-6 col-12">

                            <div class="single-footer f-link">
                                <h3>Pages</h3>
                                <ul>
                                    <li><a href="#">About Us</a></li>
                                    <li><a href="#">Our Services</a></li>
                                    <li><a href="#">Contact Us</a></li>
                                    <li><a href="#">Our Blog</a></li>
                                </ul>
                            </div>

                        </div>
                        <div class="col-lg-3 col-md-6 col-12">

                            <div class="single-footer f-link">
                                <h3>More Links</h3>
                                <ul>
                                    <li><a href="#">Topics</a></li>
                                    <li><a href="#">Terms of Use</a></li>
                                    <li><a href="#">Privacy Policy</a></li>
                                    <li><a href="#">License</a></li>
                                </ul>
                            </div>

                        </div>
                        <div class="col-lg-3 col-md-6 col-12">

                            <div class="single-footer f-link">
                                <h3>Support</h3>
                                <ul>
                                    <li><a href="#">Cookies</a></li>
                                    <li><a href="#">Forum</a></li>
                                    <li><a href="#">Support Team</a></li>
                                    <li><a href="#">Sitemap</a></li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


            <div class="footer-bottom">
                <div class="container">
                    <div class="inner">
                        <div class="row">
                            <div class="col-12">
                                <div class="left">
                                    <p>Designed and Developed by<a href="https://api-easy-net.easynet.id/" rel="nofollow" target="_blank">{{dev}}</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </footer>
	</div>
</template>

<script>
	export default{
		data(){
			return {
				company: process.env.COMPANY,
				dev: process.env.DEVELOPER
			}
		}
	}
</script>