<section id="projects" class="projects section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
      <h2>Nos Produits</h2>
      <p>Nos produits sont catégorisés selon différents services offerts par {{ config("app.name") }}</p>
    </div><!-- End Section Title -->

    <div class="container">

      <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

        <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
          <li data-filter="*" class="filter-active">Tous</li>
          @foreach ($departements as $depart)

            <li data-filter=".filter-{{ $depart->id }}">{{ $depart->lib }}</li>
          @endforeach

        </ul><!-- End Portfolio Filters -->

        <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
            @foreach ($produits as $produit)

                <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-{{ $produit->Depart_id }}">
                    <div class="portfolio-content h-100">
                    <img src="{{'storage/'.$produit->ProdPhoto }}" style="width:100%; height:310px;" class="img-fluid rounded" alt="{{$produit->Produit }}">
                    <div class="portfolio-info">
                        <h4>{{ $produit->Produit }}</h4>
                        <p>Lorem ipsum, dolor sit amet consectetur</p>
                        <a href="{{'storage/'.$produit->ProdPhoto }}" title="{{$produit->Produit }}" data-gallery="portfolio-gallery-app" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                        <a href="project-details.html" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
                    </div>
                    </div>
                </div><!-- End Portfolio Item -->
            @endforeach



        </div><!-- End Portfolio Container -->

      </div>

    </div>

  </section>
