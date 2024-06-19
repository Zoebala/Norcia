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
        Schema::create('elementsentrees', function (Blueprint $table) {
            $table->id();
            $table->integer("qte");
            $table->integer("prix");
            $table->string("lib");
            $table->unsignedBigInteger("entree_id");
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elementsentrees');
    }
};
