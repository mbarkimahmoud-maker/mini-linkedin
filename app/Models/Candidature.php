<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Candidature extends Model
{
    use HasFactory;

    protected $fillable = [
        'offre_id',
        'profil_id',
        'message',
        'statut',
    ];

    // candidature belongs to one offre
    public function offre()
    {
        return $this->belongsTo(Offre::class);
    }

    // candidature belongs to one profil
    public function profil()
    {
        return $this->belongsTo(Profil::class);
    }
}
