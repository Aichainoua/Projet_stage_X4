<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Profil Formateur (Détaillé selon vos besoins)
        Schema::create('formateurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Infos personnelles
            $table->date('date_naissance')->nullable();
            $table->foreignId('pays_id')->nullable()->constrained('pays');
            $table->string('telephone')->nullable();
            
            // Infos Professionnelles
            $table->text('biographie')->nullable();
            $table->string('specialite')->nullable(); // Domaine d'expertise
            $table->text('competences')->nullable(); // Compétences clés
            $table->integer('annees_experience')->nullable();
            $table->string('niveau_etude')->nullable(); // Niveau de formation
            $table->text('description_experience')->nullable(); // Description des formations données
            
            // Fichiers
            $table->string('cv_url')->nullable(); // Chemin vers le fichier PDF
            $table->string('lien_linkedin')->nullable();
            
            $table->timestamps();
        });

        // 2. Profil Apprenant (Simple)
        Schema::create('apprenants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('niveau_etude')->nullable();
            $table->string('interets')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('apprenants');
        Schema::dropIfExists('formateurs');
    }
};