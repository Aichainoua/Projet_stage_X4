<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;

   
    protected $fillable = [
        'user_id',
        'formation_id',
        'moyen_paiement',
        'montant_paye',
        'statut'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

       public function formation()
    {
        return $this->belongsTo(Formation::class);
    }
}