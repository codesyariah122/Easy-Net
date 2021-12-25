<template>
	<div>
		<!-- ========================= pricing-section start ========================= -->
        <section id="pricing" class="pricing-section pt-140 pb-100">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-7 col-md-10 mx-auto">
                        <div class="section-title text-center mb-60">
                            <span class="wow fadeInDown" data-wow-delay=".2s">Price</span>
                            <h2 class="wow fadeInUp" data-wow-delay=".4s">Our Pricing Plan</h2>
                            <p class="wow fadeInUp" data-wow-delay=".6s">At vero eos et accusamus et iusto odio
                                dignissimos ducimus quiblanditiis praesentium</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="pricing-btn text-center wow fadeInUp" data-wow-delay=".3s">
                            <ul class="nav justify-content-center mb-90" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-1-tab" data-bs-toggle="pill" href="#pills-1" role="tab"
                                        aria-controls="pills-1" aria-selected="true">Monthly</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-2-tab" data-bs-toggle="pill" href="#pills-2" role="tab"
                                        aria-controls="pills-2" aria-selected="false">Yearly</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-1" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-6">
                                <div class="single-pricing mb-50">
                                    <h4>Basic</h4>
                                    <h3>$15.00</h3>
                                    <ul>
                                        <li>10 Users</li>
                                        <li>Minimal Report</li>
                                        <li>100MB Data Storage</li>
                                        <li>No Support</li>
                                        <li>Single Agent</li>
                                    </ul>
                                    <a href="javascript:void(0)" class="theme-btn border-btn">Purchase Now</a>
                                    <p>No Extra Hidden Charge</p>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6">
                                <div class="single-pricing active mb-50">
                                    <h4>Standard</h4>
                                    <h3>$25.99</h3>
                                    <ul>
                                        <li>30 Users</li>
                                        <li>Minimal Report</li>
                                        <li>1GB Data Storage</li>
                                        <li>7/24 Support</li>
                                        <li>Multiple Agents</li>
                                    </ul>
                                    <a href="javascript:void(0)" class="theme-btn">Purchase Now</a>
                                    <p>No Extra Hidden Charge</p>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6">
                                <div class="single-pricing mb-50">
                                    <h4>Premium</h4>
                                    <h3>$220.00</h3>
                                    <ul>
                                        <li>Unlimited Users</li>
                                        <li>Full Report</li>
                                        <li>Unlimited Data Storage</li>
                                        <li>7/24 Support</li>
                                        <li>Multiple Agents</li>
                                    </ul>
                                    <a href="javascript:void(0)" class="theme-btn border-btn">Purchase Now</a>
                                    <p>No Extra Hidden Charge</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-2" role="tabpanel" aria-labelledby="pills-2-tab">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-6">
                                <div class="single-pricing mb-50">
                                    <h4>Basic</h4>
                                    <h3>$15.00</h3>
                                    <ul>
                                        <li>10 Users</li>
                                        <li>Minimal Report</li>
                                        <li>100MB Data Storage</li>
                                        <li>No Support</li>
                                        <li>Single Agent</li>
                                    </ul>
                                    <a href="javascript:void(0)" class="theme-btn border-btn">Purchase Now</a>
                                    <p>No Extra Hidden Charge</p>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6">
                                <div class="single-pricing active mb-50">
                                    <h4>Standard</h4>
                                    <h3>$25.99</h3>
                                    <ul>
                                        <li>30 Users</li>
                                        <li>Minimal Report</li>
                                        <li>1GB Data Storage</li>
                                        <li>7/24 Support</li>
                                        <li>Multiple Agents</li>
                                    </ul>
                                    <a href="javascript:void(0)" class="theme-btn">Purchase Now</a>
                                    <p>No Extra Hidden Charge</p>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6">
                                <div class="single-pricing mb-50">
                                    <h4>Premium</h4>
                                    <h3>$220.00</h3>
                                    <ul>
                                        <li>Unlimited Users</li>
                                        <li>Full Report</li>
                                        <li>Unlimited Data Storage</li>
                                        <li>7/24 Support</li>
                                        <li>Multiple Agents</li>
                                    </ul>
                                    <a href="javascript:void(0)" class="theme-btn border-btn">Purchase Now</a>
                                    <p>No Extra Hidden Charge</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- ========================= pricing-section end ========================= -->
        
	</div>
</template>

<script>
	export default{
		props: ['products']
	}
</script>