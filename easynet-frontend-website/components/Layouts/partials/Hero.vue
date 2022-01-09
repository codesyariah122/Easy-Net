<template>
	<div>
        <section id="home" class="hero-area index2">
            <img class="shape" src="/assets/images/hero/img-wave.png" alt="#">
            <!-- <pre>
                {{userdata}}
            </pre> -->
            <div class="hero-inner">
                <div class="container">
                    <div class="row ">
                        <div class="col-lg-6 co-12">
                            <div class="home-slider">
                                <div class="hero-text">
                                    <h1 class="wow fadeInUp" data-wow-delay=".2s"  v-html="herodata.headerText"></h1>
                                    <!-- <p class="wow fadeInUp mt-2" data-wow-delay=".3s" v-html="herodata.headerParagraph"></p> -->
                                    <div class="button wow fadeInUp" data-wow-delay=".4s">
                    
                                        <a href="#" @click="$emit('open-chat')" class="btn btn-chat btn-scroll">
                                            <i class="display-2 lni lni-support"></i> Live Chat Support
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="mobile-screen">
                                <img class="wow fadeInDown" data-wow-delay=".2s" src="/assets/images/hero/hero-1.svg" alt="#">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
</template>
<script>

	export default{
		props: ['loading','herodata']
    }
</script>