<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ressource extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre', 
        'type', 
        'chemin_fichier', 
        'cours_id',
    ];

    
    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }

    
    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }
}