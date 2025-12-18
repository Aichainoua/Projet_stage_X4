<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pays', function (Blueprint $table) {
            $table->id();
            $table->string('nom_fr'); // Ex: Cameroun
            $table->string('nom_en')->nullable(); // Ex: Cameroon
            $table->string('code', 3)->nullable(); // Ex: CMR
            $table->string('indicatif')->nullable(); // Ex: +237
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pays');
    }
};