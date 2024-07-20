<?php

use App\Livewire\Apropos;
use App\Livewire\Produit;
use App\Livewire\Service;
use App\Livewire\Identification;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {

    // return redirect("/admin");
    return view('welcome');
})->name("home");
Route::get("/apropos",Apropos::class)->name("apropos");
Route::get("/service",Service::class)->name("service");
Route::get("/produit",Produit::class)->name("produit");
Route::get("/identification",Identification::class)->name("identification");
