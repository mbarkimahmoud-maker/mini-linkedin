<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profil extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'titre',
        'bio',
        'localisation',
        'disponible',
    ];
    // profil belongs to one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // profil has many competences through pivot
    public function competences()
    {
        return $this->belongsToMany(Competence::class, 'profil_competence')
                    ->withPivot('niveau')
                    ->withTimestamps();
    }

    // profil has many candidatures
    public function candidatures()
    {
        return $this->hasMany(Candidature::class);
    }
}
