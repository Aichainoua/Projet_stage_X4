<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('apprenants', function (Blueprint $table) {
            $table->id();
            // La clé étrangère qui relie l'apprenant au user
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Ajoute d'autres champs si nécessaire (ex: niveau, matricule...)
            // $table->string('niveau')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('apprenants');
    }
};