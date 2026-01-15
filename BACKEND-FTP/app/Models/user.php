<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // Important pour l'API

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'nom',
        'prenom',
        'email',
        'password',
        'role',   // admin, formateur, apprenant
        'status', // pending, active...
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    
    public function formateur()
    {
        return $this->hasOne(Formateur::class);
    }

        public function apprenant()
    {
        return $this->hasOne(Apprenant::class);
    }
}