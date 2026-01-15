<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    use HasFactory;

    protected $fillable = [
        'formation_id',
        'titre',
        'date_debut',
        'date_fin',
        'type_seance', 
        'lien_visio'
    ];

    
    protected $casts = [
        'date_debut' => 'datetime',
        'date_fin' => 'datetime',
    ];

    
    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }
}