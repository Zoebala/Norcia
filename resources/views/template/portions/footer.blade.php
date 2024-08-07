<footer id="footer" class="footer">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="logo d-flex align-items-center">
            <span class="sitename">{{ config("app.name") }}</span>
          </a>
          <div class="footer-contact pt-3">
            <p>45, Av. Mueneditu Street</p>
            <p>Mbanza-Ngungu, Disengomoka </p>
            <p class="mt-3"><strong>Phone:</strong> <span>+243 896071804</span></p>
            <p><strong>Email:</strong> <span>norciabusiness@tech.com</span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-md-3 footer-links">
          <h4>Liens Utiles</h4>
          <ul>
            <li><a href="{{ route("home") }}" class="{{ Route::is("home") ? 'active':' '; }}">Accueil</a></li>
            <li><a href="{{ route("apropos") }}" class="{{ Route::is("apropos") ? 'active':' '; }}">Apropos</a></li>
            <li><a href="{{ route("service") }}" class="{{ Route::is("service") ? 'active':' '; }}">Services</a></li>
            <li><a href="{{ route("produit") }}" class="{{ Route::is("produit") ? 'active':' '; }}">Produits</a></li>
          </ul>
        </div>

        <div class="col-lg-3 col-md-3 footer-links">
          <h4>Nos Services</h4>
          <ul>
            @foreach ($services as $service)
                <li><a href="#">{{ $service->lib }}</a></li>

            @endforeach

          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Nos Opérations</h4>
          <ul>
            <li><a href="#">Commander</a></li>
            <li><a href="#">S'identifier</a></li>
            <li><a href="#">Se Connecter</a></li>
          </ul>
        </div>


      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">{{ config("app.name") }}</strong> <span>Tous droits Reservés</span></p>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
        Designed by <a href="https://bootstrapmade.com/">Zoé Ngoy</a>
      </div>
    </div>

  </footer>
  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="template/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="template/assets/vendor/php-email-form/validate.js"></script>
  <script src="template/assets/vendor/aos/aos.js"></script>
  <script src="template/assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="template/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="template/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="template/assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="template/assets/vendor/purecounter/purecounter_vanilla.js"></script>

  <!-- Main JS File -->
  <script src="template/assets/js/main.js"></script>
  <script src="js/typed.js"></script>
   <script>
            var typed = new Typed('.typed-words', {
            strings: ["Norcia Business Group","Vous présente","Norcia Chips","Norcia Juice","Norcia Beauty","Norcia Apps"],
            typeSpeed: 80,
            backSpeed: 80,
            backDelay: 4000,
            startDelay: 1000,
            loop: true,
            showCursor: true
            });
    </script>

</body>

</html>
