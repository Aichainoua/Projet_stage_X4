<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {

       
        Schema::create('niveaux', function (Blueprint $table) {
            $table->id();
            $table->string('libelle'); 
            $table->timestamps();
        });

       
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('nom'); 
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