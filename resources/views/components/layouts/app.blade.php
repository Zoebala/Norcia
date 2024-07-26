<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? config("app.name") }}</title>
         @include("template.portions.t_head")
    </head>
    <body>
        @include("template.portions.t_nav")
        <main class="main">

            <!-- Page Title -->
            <div class="page-title" style="background-image: url(template/assets/img/page-title-bg.jpg);">
              <div class="container position-relative">
                <h1>{{ $pageTitle }}</h1>
                <nav class="breadcrumbs">
                  <ol>
                    <li><a href="/">Accueil</a></li>
                    <li class="current">{{ $pageTitle }}</li>
                  </ol>
                </nav>
              </div>
            </div>
             <!-- End Page Title -->
            {{ $slot }}
        </main>

        @livewire("footer")
    </body>
</html>
