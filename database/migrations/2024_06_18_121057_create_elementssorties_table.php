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
        Schema::create('elementssorties', function (Blueprint $table) {
            $table->id();
            $table->integer("qte");
            $table->unsignedBigInteger("produit_id");
            $table->unsignedBigInteger("sortie_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elementssorties');
    }
};
