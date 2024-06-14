<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('entrees', function (Blueprint $table) {
            $table->id();
            $table->integer("qte");
            $table->integer("prix");
            $table->unsignedBigInteger("produit_id");
            $table->unsignedBigInteger("departement_id");
            $table->unsignedBigInteger("fournisseur_id");
            $table->unsignedBigInteger("anneer_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entrees');
    }
};
