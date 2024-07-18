<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>{{ config("app.name") }}</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

@include("template.portions.t_head")
</head>

<body class="index-page">


@include("template.portions.t_nav")
<main class="main">

    <!-- Hero Section -->
    @include("template.portions.t_home")
    <!-- /Hero Section -->

    <!-- Get Started Section -->
    @include("template.portions.t_contact")
    <!-- /Get Started Section -->

    <!-- Services Section -->
    @include("template.portions.service")
    <!-- /Services Section -->




    <!-- Features Section -->
    @include("template.portions.service_onglets")

    <!-- /Features Section -->

    <!-- Projects Section -->
    @include("template.portions.produits")
    <!-- /Projects Section -->

    <!-- Testimonials Section -->
    @include("template.portions.temoignages")
    <!-- /Testimonials Section -->

    <!-- Recent Blog Posts Section -->

    <!-- /Recent Blog Posts Section -->

  </main>

  @include("template.portions.footer")


