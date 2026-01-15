<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'prix',
        'niveau',
        'date_ouverture', 
        'prerequis',
        'competences',
        'est_mentore',
        'user_id' 
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cours()
    {
        return $this->hasMany(Cours::class);
    }

   
    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }
}