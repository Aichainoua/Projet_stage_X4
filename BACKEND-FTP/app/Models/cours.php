<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre', 
        'description', 
        'ordre', 
        'formation_id', 
        'duree'
    ];

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

   
    public function ressources()
    {
        return $this->hasMany(Ressource::class);
    }
}