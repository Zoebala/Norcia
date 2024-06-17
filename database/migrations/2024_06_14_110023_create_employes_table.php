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
        Schema::create('employes', function (Blueprint $table) {
            $table->id();
            $table->string("matricule")->nullable();
            $table->string("nom");
            $table->string("postnom");
            $table->string("prenom");
            $table->string("tel")->nullable();
            $table->char("genre",1);
            $table->date("datenais");
            $table->unsignedBigInteger("fonction_id");
            $table->unsignedBigInteger("annee_id");
            $table->string("email")->nullable();
            $table->string("adresse")->nullable();
            $table->string("lieu_naissance")->nullable();
            $table->string("pays_naissance")->nullable();
            $table->string("position")->nullable();
            $table->date("date_embauche")->nullable();
            $table->string("photo")->nullable();
            $table->string("province")->nullable();
            $table->string("situation_familiale")->nullable();
            $table->integer("nbre_enfant")->nullable();
            
            $table->string("qualification")->nullable();
            $table->json("formation_suivie")->nullable();
            $table->json("elements_dossiers")->nullable();
            $table->string("institution_obt_diplome")->nullable();
            $table->string("annee_obt_diplome")->nullable();
            $table->string("lieu_obt_diplome")->nullable();
            $table->string("pays_obt_diplome")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employes');
    }
};
