<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Competence extends Model
{
     use HasFactory;

    protected $fillable = [
        'nom',
        'categorie',
    ];

    // competence belongs to many profils through pivot
    public function profils()
    {
        return $this->belongsToMany(Profil::class, 'profil_competence')
                    ->withPivot('niveau')
                    ->withTimestamps();
    }
}
