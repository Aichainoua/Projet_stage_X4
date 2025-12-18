<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormateurDomaine extends Model
{
    protected $fillable = [
        'formateur_id',
        'domaine',
    ];

    public function formateur()
    {
        return $this->belongsTo(Formateur::class);
    }
}