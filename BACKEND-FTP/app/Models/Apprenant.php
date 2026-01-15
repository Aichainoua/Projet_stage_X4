<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apprenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'niveau_etude',
        'interets'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
   
    public function inscriptions()
    {
        return $this->hasMany(Inscription::class, 'user_id', 'user_id');
    }
}