<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    use HasFactory;

    // Attention au pluriel : Laravel cherche la table 'cours' (qui existe)
    protected $table = 'cours'; 

    protected $fillable = ['formation_id', 'titre', 'description', 'ordre'];

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }
}