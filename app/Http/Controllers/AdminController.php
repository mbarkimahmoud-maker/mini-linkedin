<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Offre;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function listeUsers(){
        $user=User::latest()->get();
        return response()->json([
            'data'=>$user,
        ],200);
    }

    public function supprimerUser(User $user){
        $user->delete();
        return response()->json([
            'message'=>'Utilisateur supprimer avec succes'
        ],200);
    }

    public function toggleoffre(Offre $offre){
        $offre->update(['actif'=>! $offre->actif]);
        return response()->json([
            'message' => $offre->actif ? 'Offre activée avec succès.' : 'Offre désactivée avec succès.',
            'offre'   => $offre->fresh(),
        ], 200);
    }
}
