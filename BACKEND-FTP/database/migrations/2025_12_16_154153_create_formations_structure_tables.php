<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. La Formation
        Schema::create('formations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formateur_id')->constrained('formateurs')->onDelete('cascade');
            $table->foreignId('niveau_id')->nullable()->constrained('niveaux');
            $table->foreignId('categorie_id')->nullable()->constrained('categories');
            
            $table->string('titre');
            $table->text('description');
            $table->decimal('prix', 10, 2)->default(0); // Gratuit si 0
            $table->integer('duree_heures')->nullable();
            $table->string('image_url')->nullable(); // Miniature
            $table->boolean('est_publie')->default(false);
            $table->timestamps();
        });

        // 2. Les Chapitres / Cours
        Schema::create('cours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formation_id')->constrained('formations')->onDelete('cascade');
            $table->string('titre');
            $table->text('description')->nullable();
            $table->integer('ordre')->default(1); // 1, 2, 3...
            $table->timestamps();
        });

        // 3. Les Ressources (Vidéos, PDF dans les cours)
        Schema::create('ressources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cours_id')->constrained('cours')->onDelete('cascade');
            $table->string('titre');
            $table->enum('type', ['video', 'pdf', 'lien', 'quiz']);
            $table->string('url'); // Chemin fichier ou URL Youtube
            $table->integer('duree_minutes')->nullable();
            $table->timestamps();
        });

        // 4. Les Séances (Vos "Sessions" de tutorat)
        Schema::create('seances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formation_id')->constrained('formations')->onDelete('cascade');
            $table->string('titre');
            $table->dateTime('date_debut');
            $table->dateTime('date_fin');
            $table->string('lien_visio')->nullable(); // Zoom/Meet
            $table->text('notes')->nullable();
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