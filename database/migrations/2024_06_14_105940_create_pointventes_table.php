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
        Schema::create('pointventes', function (Blueprint $table) {
            $table->id();
            $table->string("lib");
            $table->string("adresse");
            $table->string("tel",10)->nullable();
            $table->unsignedBigInteger("annee_id");
            $table->boolean("actif")->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pointventes');
    }
};
