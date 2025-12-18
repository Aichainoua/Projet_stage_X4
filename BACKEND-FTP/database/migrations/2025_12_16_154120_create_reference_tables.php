<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {

        // Table 2 : Niveaux (pour la Formation)
        Schema::create('niveaux', function (Blueprint $table) {
            $table->id();
            $table->string('libelle'); // Ex: Débutant, Intermédiaire, Expert
            $table->timestamps();
        });

        // Table 3 : Catégories / Types (pour la Formation)
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('nom'); // Ex: Informatique, Langues, Marketing
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
        Schema::dropIfExists('niveaux');
        Schema::dropIfExists('pays');
    }
};