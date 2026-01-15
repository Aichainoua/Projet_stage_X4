<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
     
        Schema::create('formateurs', function (Blueprint $table) {
            $table->id();
        
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
         
            $table->string('status')->default('pending'); 
            $table->text('motif_rejet')->nullable(); 
            $table->date('date_naissance')->nullable();
            $table->foreignId('pays_id')->nullable()->constrained('pays');
            $table->string('telephone')->nullable();
            $table->text('biographie')->nullable();
            $table->text('specialite')->nullable(); 
            $table->text('competences')->nullable(); 
            $table->integer('annees_experience')->nullable();
            $table->string('niveau_etude')->nullable(); 
            $table->text('description_experience')->nullable();
            $table->string('cv_url')->nullable();
            $table->string('lien_linkedin')->nullable();
            
            $table->timestamps();
        });

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