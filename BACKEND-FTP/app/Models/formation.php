<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    use HasFactory;

    protected $fillable = [
        'formateur_id',
        'niveau_id',
        'categorie_id',
        'titre',
        'description',
        'prix',
        'duree_heures',
        'image_url',
        'est_publie'
    ];

    // Relation : Appartient à un formateur
    public function formateur()
    {
        return $this->belongsTo(Formateur::class);
    }

    // Relation : A plusieurs cours (chapitres)
    public function cours()
    {
        return $this->hasMany(Cours::class); // On créera Cours.php juste après pour éviter une erreur
    }
    
    // Relation : A plusieurs inscriptions
    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }
}