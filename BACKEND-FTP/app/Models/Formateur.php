<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formateur extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pays_id',
        'date_naissance',
        'telephone',
        'biographie',
        'specialite', // Domaine d'expertise
        'competences',
        'annees_experience',
        'niveau_etude',
        'description_experience',
        'cv_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Relation vers Pays (Ex: $formateur->pays->nom)
    public function pays()
    {
        return $this->belongsTo(Pays::class);
    }
}