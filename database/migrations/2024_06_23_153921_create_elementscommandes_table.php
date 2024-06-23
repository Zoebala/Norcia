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
        Schema::create('elementscommandes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("commande_id");
            $table->unsignedBigInteger("produit_id");
            $table->Integer("qte");
            $table->Integer("total");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elementscommandes');
    }
};
