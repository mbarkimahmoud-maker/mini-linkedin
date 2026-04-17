<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\Offre;
use Illuminate\Http\Request;
use App\Events\CandidatureDeposee;
use App\Events\StatutCandidatureMis;



class CandidatureController extends Controller
{  
    //Un candidat postule à une offre.
    
    public function postuler(Request $request, Offre $offre)
    {
        //  Récupérer le profil du candidat connecté
        $profil = $request->user()->profil;

        //  Vérifier que le candidat a bien un profil créé
        if (!$profil) {
            return response()->json([
                'message' => 'Vous devez créer votre profil avant de postuler.'
            ], 403);
        }

        // Vérifier que le candidat n'a pas déjà postulé à cette offre
        $dejaPostule = Candidature::where('offre_id', $offre->id)
            ->where('profil_id', $profil->id)
            ->exists();

        if ($dejaPostule) {
            return response()->json([
                'message' => 'Vous avez déjà postulé à cette offre.'
            ], 400);
        }

        // Valider les données envoyées
        $data = $request->validate([
            'message' => 'nullable|string|max:1000',
        ]);

        //  Créer la candidature
        $candidature = Candidature::create([
            'offre_id'  => $offre->id,
            'profil_id' => $profil->id,
            'message'   => $data['message'] ?? null,
            'statut'    => 'en_attente', // statut par défaut
        ]);

        CandidatureDeposee::dispatch($candidature->load(['profil.user', 'offre']));

        return response()->json([
            'message'      => 'Candidature envoyée avec succès.',
            'candidature'  => $candidature->load('offre'),
        ], 201);
    }

    //GET /api/mes-candidatures — liste de ses propres candidatures

    public function mesCandidatures(Request $request)
    {
        $profil = $request->user()->profil;

        if (!$profil) {
            return response()->json([
                'message' => 'Aucun profil trouvé.'
            ], 404);
        }

        $candidatures = Candidature::where('profil_id', $profil->id)
            ->with('offre')
            ->latest()
            ->get();

        return response()->json($candidatures);
    }

    //GET /api/offres/{offre}/candidatures — candidatures reçues(recruteur propriétaire)

    public function offreCandidatures(Request $request, Offre $offre)
    {
        if ($request->user()->id !== $offre->user_id) {
            return response()->json([
                'message' => 'Accès refusé. Vous n\'êtes pas propriétaire de cette offre.'
            ], 403);
        }
        $candidatures = Candidature::where('offre_id', $offre->id)
            ->with('profil')
            ->latest()
            ->get();

        return response()->json($candidatures);
    }
    //PATCH /api/candidatures/{candidature}/statut — changer le statut(recruteur)

    public function changerStatut(Request $request, Candidature $candidature)
    {

        if ($request->user()->id !== $candidature->offre->user_id) {
            return response()->json([
                'message' => 'Accès refusé. Vous n\'êtes pas propriétaire de cette offre.'
            ], 403);
        }
        $data = $request->validate([
            'statut' => 'required|in:en_attente,acceptee,refusee',
        ]);
        // On capture l'ancien statut AVANT le update
        $ancienStatut = $candidature->statut;

        $candidature->update(['statut' => $data['statut']]);

        StatutCandidatureMis::dispatch($candidature, $ancienStatut, $data['statut']);

        return response()->json([
            'message'      => 'Statut mis à jour avec succès.',
            'candidature'  => $candidature->fresh(), // recharge depuis la BDD
        ]);
    }
}