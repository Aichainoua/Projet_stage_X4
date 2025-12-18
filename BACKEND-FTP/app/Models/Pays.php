<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pays extends Model
{
    use HasFactory;

    // IMPORTANT : On précise que la table s'appelle 'pays' (au pluriel) 
    // sinon Laravel va chercher une table 'payss' ou 'pay'
    protected $table = 'pays'; 

    protected $fillable = ['nom', 'code', 'indicatif'];

    public function formateurs()
    {
        return $this->hasMany(Formateur::class);
    }
}