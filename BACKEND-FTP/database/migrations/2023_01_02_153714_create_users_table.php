<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nom complet affiché
            $table->string('nom')->nullable(); // Nom de famille
            $table->string('prenom')->nullable(); // Prénom
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'formateur', 'apprenant'])->default('apprenant');
            $table->enum('status', ['pending', 'active', 'rejected', 'suspended'])->default('pending');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};