<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. La Formation (Alignée avec ton formulaire VueJS)
        Schema::create('formations', function (Blueprint $table) {
            $table->id();
            
            // Relation avec l'utilisateur connecté (le formateur)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            
            // Champs du formulaire
            $table->string('titre');
            $table->text('description');
            $table->integer('prix')->default(0); // Integer pour FCFA c'est mieux
            $table->string('niveau')->default('Débutant'); // Stocké en texte directement (plus simple)
            $table->date('date_ouverture')->nullable();
            
            // Nouveaux champs demandés
            $table->text('prerequis')->nullable();
            $table->text('competences')->nullable();
            $table->boolean('est_mentore')->default(false); // Case à cocher "Session"
            
            // Autres champs utiles
            $table->string('image_url')->nullable(); 
            $table->boolean('est_publie')->default(false);
            
            $table->timestamps();
        });

        // 2. Les Chapitres / Cours
        Schema::create('cours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formation_id')->constrained('formations')->onDelete('cascade');
            $table->string('titre');
            $table->text('description')->nullable();
            $table->integer('ordre')->default(1);
            $table->timestamps();
        });

        
        Schema::create('ressources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cours_id')->constrained('cours')->onDelete('cascade');
            $table->string('titre'); 
            $table->string('type');  
            $table->string('chemin_fichier'); 
            $table->timestamps();
        });

        
        Schema::create('seances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formation_id')->constrained('formations')->onDelete('cascade');
            $table->string('titre');
            $table->dateTime('date_debut');
            $table->dateTime('date_fin');
            $table->string('lien_visio')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        
        Schema::dropIfExists('seances');
        Schema::dropIfExists('ressources');
        Schema::dropIfExists('cours');
        Schema::dropIfExists('formations');
    }
};