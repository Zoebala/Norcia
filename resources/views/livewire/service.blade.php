<div>
    <section id="features" class="features section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Nos Services</h2>
            <p>{{ config("app.name") }} met à votre disposition divers services, que voici : </p>
        </div><!-- End Section Title -->
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
                    <h3 class="fst-italic">Description</h3>
                    <p class="fst-italic" style="text-align: justify; text-indent:2.5em;">
                        {{$depart->description}}
                    </p>
                    <ul>
                        <li><i class="bi bi-check2-all"></i> <span>L'expertise</span></li>
                        <li><i class="bi bi-check2-all"></i> <span>la qualité, l'originalité</span></li>
                        <li><i class="bi bi-check2-all"></i> <span>L'intégrité</span></li>
                        <li><i class="bi bi-check2-all"></i> <span>sont les valeurs prônées par {{ config("app.name") }}</span></li>
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


     



</div>
