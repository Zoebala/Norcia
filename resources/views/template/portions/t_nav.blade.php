<style>

    #navmenu li a{
        font-size:1em;
    }
    li a span{
        text-transform: lowercase;


    }
    /* alignement des liens de la navbar à gauche sur tablette et smarphones */
    @media screen and (max-width:1155px){
       #navmenu li a {
            display:flex;
            justify-content:left;
        }
    }
</style>
<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="template/assets/img/logo.png" alt=""> -->
        <h1 class="sitename"><img src="{{ 'images/Norcia Logo.png' }}" alt="logo" width="60px" class="img-fluid rounded"> {{ config("app.name") }}</h1> <span>.</span>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ route("home") }}" class="{{ Route::is("home") ? 'active':' '; }}">A <span>ccueil</span></a></li>
          <li><a href="#features" >S <span>ervices</span></a></li>
          <li><a href="#projects">P <span>roduits</span></a></li>

          <li class="dropdown"><a href="#"><span>Opérations</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
                <li><a href="#">Dropdown 1</a></li>
                <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                    <ul>
                        <li><a href="#"> sous opération 1</a></li>

                    </ul>
                </li>
                <li><a href="#">Dropdown 2</a></li>
            </ul>
        </li>
        {{-- <li><a href="{{ route("identification") }}" class="{{ Route::is("identification") ? 'active':' '; }}">S <span>'identifier</span> </a></li> --}}
        <li><a href="#footer">A <span>propos</span></a></li>
        <li><a href="{{ route("filament.admin.auth.login") }}" class="{{ Route::is("filament.admin.auth.login") ? 'active':' '; }}">C <span>onnexion</span> </a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>
