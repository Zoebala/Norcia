<div>
    <section id="features" class="features section">

        <div class="container">

          <ul class="nav nav-tabs row  g-2 d-flex" data-aos="fade-up" data-aos-delay="100" role="tablist">


            @foreach ($departements as $depart)

                <li class="nav-item col-3" role="presentation">
                <a class="nav-link {{ $loop->first ? 'active show':'' }}" data-bs-toggle="tab" data-bs-target="#features-tab-{{ $depart->id }}" aria-selected="false" tabindex="-1" role="tab">
                    <h4>{{ $depart->lib }}</h4>
                </a><!-- End tab nav item -->

                </li>
            @endforeach


          </ul>

          <div class="tab-content" data-aos="fade-up" data-aos-delay="200">

            @foreach ($departements as $depart)

                <div class="tab-pane fade {{ $loop->first ? 'active show':'' }}" id="features-tab-{{ $depart->id }}" role="tabpanel">
                <div class="row">
                    <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0 d-flex flex-column justify-content-center">
                    <h3>Description</h3>
                    <p class="fst-italic">
                        {{$depart->description}}
                    </p>
                    <ul>
                        <li><i class="bi bi-check2-all"></i> <span>Ullamco laboris nisi ut aliquip ex ea commodo consequat.</span></li>
                        <li><i class="bi bi-check2-all"></i> <span>Duis aute irure dolor in reprehenderit in voluptate velit.</span></li>
                        <li><i class="bi bi-check2-all"></i> <span>Provident mollitia neque rerum asperiores dolores quos qui a. Ipsum neque dolor voluptate nisi sed.</span></li>
                        <li><i class="bi bi-check2-all"></i> <span>Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate trideta storacalaperda mastiro dolore eu fugiat nulla pariatur.</span></li>
                    </ul>
                    </div>
                    <div class="col-lg-6 order-1 order-lg-2 text-center">
                    <img src="{{ 'storage/'.$depart->photo }}" alt="logo" style="height: 500px; width:100%;" class="img-fluid rounded">
                    </div>
                </div>
                </div><!-- End tab content item -->
            @endforeach



          </div>

        </div>

      </section>


        <!-- Testimonials Section -->
        <section id="testimonials" class="testimonials section">

          <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="swiper init-swiper">
              <script type="application/json" class="swiper-config">
                {
                  "loop": true,
                  "speed": 600,
                  "autoplay": {
                    "delay": 5000
                  },
                  "slidesPerView": "auto",
                  "pagination": {
                    "el": ".swiper-pagination",
                    "type": "bullets",
                    "clickable": true
                  },
                  "breakpoints": {
                    "320": {
                      "slidesPerView": 1,
                      "spaceBetween": 40
                    },
                    "1200": {
                      "slidesPerView": 2,
                      "spaceBetween": 20
                    }
                  }
                }
              </script>
              <div class="swiper-wrapper">

                <div class="swiper-slide">
                  <div class="testimonial-wrap">
                    <div class="testimonial-item">
                      <img src="template/assets/img/testimonials/testimonials-1.jpg" class="testimonial-img" alt="">
                      <h3>Saul Goodman</h3>
                      <h4>Ceo &amp; Founder</h4>
                      <div class="stars">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                      </div>
                      <p>
                        <i class="bi bi-quote quote-icon-left"></i>
                        <span>Proin iaculis purus consequat sem cure digni ssim donec porttitora entum suscipit rhoncus. Accusantium quam, ultricies eget id, aliquam eget nibh et. Maecen aliquam, risus at semper.</span>
                        <i class="bi bi-quote quote-icon-right"></i>
                      </p>
                    </div>
                  </div>
                </div><!-- End testimonial item -->

                <div class="swiper-slide">
                  <div class="testimonial-wrap">
                    <div class="testimonial-item">
                      <img src="template/assets/img/testimonials/testimonials-2.jpg" class="testimonial-img" alt="">
                      <h3>Sara Wilsson</h3>
                      <h4>Designer</h4>
                      <div class="stars">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                      </div>
                      <p>
                        <i class="bi bi-quote quote-icon-left"></i>
                        <span>Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid cillum eram malis quorum velit fore eram velit sunt aliqua noster fugiat irure amet legam anim culpa.</span>
                        <i class="bi bi-quote quote-icon-right"></i>
                      </p>
                    </div>
                  </div>
                </div><!-- End testimonial item -->

                <div class="swiper-slide">
                  <div class="testimonial-wrap">
                    <div class="testimonial-item">
                      <img src="template/assets/img/testimonials/testimonials-3.jpg" class="testimonial-img" alt="">
                      <h3>Jena Karlis</h3>
                      <h4>Store Owner</h4>
                      <div class="stars">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                      </div>
                      <p>
                        <i class="bi bi-quote quote-icon-left"></i>
                        <span>Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam duis minim tempor labore quem eram duis noster aute amet eram fore quis sint minim.</span>
                        <i class="bi bi-quote quote-icon-right"></i>
                      </p>
                    </div>
                  </div>
                </div><!-- End testimonial item -->

                <div class="swiper-slide">
                  <div class="testimonial-wrap">
                    <div class="testimonial-item">
                      <img src="template/assets/img/testimonials/testimonials-4.jpg" class="testimonial-img" alt="">
                      <h3>Matt Brandon</h3>
                      <h4>Freelancer</h4>
                      <div class="stars">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                      </div>
                      <p>
                        <i class="bi bi-quote quote-icon-left"></i>
                        <span>Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat minim velit minim dolor enim duis veniam ipsum anim magna sunt elit fore quem dolore labore illum veniam.</span>
                        <i class="bi bi-quote quote-icon-right"></i>
                      </p>
                    </div>
                  </div>
                </div><!-- End testimonial item -->

                <div class="swiper-slide">
                  <div class="testimonial-wrap">
                    <div class="testimonial-item">
                      <img src="template/assets/img/testimonials/testimonials-5.jpg" class="testimonial-img" alt="">
                      <h3>John Larson</h3>
                      <h4>Entrepreneur</h4>
                      <div class="stars">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                      </div>
                      <p>
                        <i class="bi bi-quote quote-icon-left"></i>
                        <span>Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor noster veniam enim culpa labore duis sunt culpa nulla illum cillum fugiat legam esse veniam culpa fore nisi cillum quid.</span>
                        <i class="bi bi-quote quote-icon-right"></i>
                      </p>
                    </div>
                  </div>
                </div><!-- End testimonial item -->

              </div>
              <div class="swiper-pagination"></div>
            </div>

          </div>

        </section><!-- /Testimonials Section -->



</div>
