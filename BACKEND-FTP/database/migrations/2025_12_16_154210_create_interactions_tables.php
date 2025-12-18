<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Table Pivot : Inscriptions (Qui a acheté quoi ?)
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('formation_id')->constrained()->onDelete('cascade');
            
            $table->decimal('montant_paye', 10, 2);
            $table->string('moyen_paiement')->nullable(); // OM, MOMO
            $table->string('ref_transaction')->nullable();
            $table->string('statut')->default('en_attente'); // paye, en_attente, echoue
            $table->dateTime('date_inscription')->useCurrent();
            
            $table->timestamps();
        });

        // Table Pivot : Progression (Qu'est-ce qui est vu ?)
        Schema::create('progressions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('ressource_id')->constrained()->onDelete('cascade');
            
            $table->boolean('est_termine')->default(false);
            $table->timestamp('date_fin')->nullable();
            
            $table->timestamps();
            
            // Un user ne peut avoir qu'une ligne de progression par ressource
            $table->unique(['user_id', 'ressource_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('progressions');
        Schema::dropIfExists('inscriptions');
    }
};