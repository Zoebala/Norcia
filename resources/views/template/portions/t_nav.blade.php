<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="template/assets/img/logo.png" alt=""> -->
        <h1 class="sitename"><img src="{{ 'images/Norcia Logo.png' }}" alt="logo" width="60px" class="img-fluid rounded"> {{ config("app.name") }}</h1> <span>.</span>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ route("home") }}" class="{{ Route::is("home") ? 'active':' '; }}">Accueil</a></li>
          <li><a href="{{ route("apropos") }}" class="{{ Route::is("apropos") ? 'active':' '; }}">Apropos</a></li>
          <li><a href="{{ route("service") }}" class="{{ Route::is("service") ? 'active':' '; }}">Services</a></li>
          <li><a href="{{ route("produit") }}" class="{{ Route::is("produit") ? 'active':' '; }}">Produits</a></li>
          <li class="dropdown"><a href="#"><span>Opérations</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
                <li><a href="#">Dropdown 1</a></li>
                <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                    <ul>
                        <li><a href="#">Deep Dropdown 1</a></li>
                        <li><a href="#">Deep Dropdown 2</a></li>
                        <li><a href="#">Deep Dropdown 3</a></li>
                        <li><a href="#">Deep Dropdown 4</a></li>
                        <li><a href="#">Deep Dropdown 5</a></li>
                    </ul>
                </li>
                <li><a href="#">Dropdown 2</a></li>
                <li><a href="#">Dropdown 3</a></li>
                <li><a href="#">Dropdown 4</a></li>
            </ul>
        </li>
        <li><a href="{{ route("identification") }}" class="{{ Route::is("identification") ? 'active':' '; }}">S'identifier</a></li>
        <li><a href="{{ route("filament.admin.auth.login") }}" class="{{ Route::is("filament.admin.auth.login") ? 'active':' '; }}">Connexion</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>
