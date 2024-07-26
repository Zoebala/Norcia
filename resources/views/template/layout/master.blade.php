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
    @livewire("service")
    @livewire("equipe")
    @livewire("produit")
    @livewire("avis")



  </main>

  @livewire("footer")


