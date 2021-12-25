<template>
	<div>
		<!-- ========================= gallery style-2 start ========================= -->
    <section id="news" class="gallery-section gallery-style-2 mb-80">
      <div class="gallery-wrapper">
        <div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-10 col-md-9">
              <div class="section-title mb-60">
                <h3 class="mb-15">Easy Net News Info</h3>
                <p>
                  Nantikan info-info dan tips menarik terbaru seputar internet dan penggunaan internet di website Easy Net ini.
                </p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="single-gallery">
                <div class="image">
                  <img src="assets/img/gallery/gallery-2/gallery-1.jpg" alt="">
                  <div class="overlay">
                    <div class="action">
                      <a href="#0"> <i class="lni lni-link"></i> </a>
                    </div>
                  </div>
                </div>
                <div class="info">
                  <h5>Web Design</h5>
                  <p>Short description for the ones who look for something new. Awesome!</p>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="single-gallery">
                <div class="image">
                  <img src="assets/img/gallery/gallery-2/gallery-2.jpg" alt="">
                  <div class="overlay">
                    <div class="action">
                      <a href="#0"> <i class="lni lni-link"></i> </a>
                    </div>
                  </div>
                </div>
                <div class="info">
                  <h5>Web Design</h5>
                  <p>Short description for the ones who look for something new. Awesome!</p>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="single-gallery">
                <div class="image">
                  <img src="assets/img/gallery/gallery-2/gallery-3.jpg" alt="">
                  <div class="overlay">
                    <div class="action">
                      <a href="#0"> <i class="lni lni-link"></i> </a>
                    </div>
                  </div>
                </div>
                <div class="info">
                  <h5>Web Design</h5>
                  <p>Short description for the ones who look for something new. Awesome!</p>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="single-gallery">
                <div class="image">
                  <img src="assets/img/gallery/gallery-2/gallery-4.jpg" alt="">
                  <div class="overlay">
                    <div class="action">
                      <a href="#0"> <i class="lni lni-link"></i> </a>
                    </div>
                  </div>
                </div>
                <div class="info">
                  <h5>Web Design</h5>
                  <p>Short description for the ones who look for something new. Awesome!</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- ========================= gallery style-2 end ========================= -->
	</div>
</template>

<script>
	export default{
		mounted(){
			this.ImageLoaded()
		},
		methods:{
			ImageLoaded(){
				imagesLoaded( '#gallery', function() {
					var elem = document.querySelector('.grid');
					var iso = new Isotope(elem, {
				            itemSelector: '.grid-item',
				            masonry: {
				            // use outer width of grid-sizer for columnWidth
				            columnWidth: '.grid-item'
				        }
				    });

				});
			}
		}
	}
</script>