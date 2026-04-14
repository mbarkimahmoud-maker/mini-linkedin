<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profil;
use App\Models\Competence;

class ProfilController extends Controller
{
    //Créer son profil
    public function store(Request $request)
    {
        $user = auth('api')->user();
        if ($user->profil) {
            return response()->json([
                'message' => 'Vous avez déjà un profil'
            ], 400);
        }

        $request->validate([
            'titre'       => 'required|string|max:255',
            'bio'         => 'nullable|string',
            'localisation'=> 'nullable|string|max:255',
            'disponible'  => 'nullable|boolean',
        ]);

        $profil = Profil::create([
            'user_id'      => $user->id,
            'titre'        => $request->titre,
            'bio'          => $request->bio,
            'localisation' => $request->localisation,
            'disponible'   => $request->disponible ?? true,
        ]);

        return response()->json([
            'message' => 'Profil créé avec succès',
            'data'    => $profil,
        ], 201);
    }

    //Consulter son profil
    public function show()
    {
        $user = auth('api')->user();
        $profil = $user->profil;

        if (!$profil) {
            return response()->json([
                'message' => 'Vous n\'avez pas encore de profil'
            ], 404);
        }

        return response()->json([
            'message' => 'Profil récupéré avec succès',
            'data'    => $profil->load('competences'),
        ]);
    }

    // Modifier son profil
    public function update(Request $request)
    {
        $user = auth('api')->user();

        $profil = $user->profil;

        if (!$profil) {
            return response()->json([
                'message' => 'Vous n\'avez pas encore de profil'
            ], 404);
        }

        $request->validate([
            'titre'        => 'sometimes|string|max:255',
            'bio'          => 'nullable|string',
            'localisation' => 'nullable|string|max:255',
            'disponible'   => 'nullable|boolean',
        ]);

        $profil->update($request->only([
            'titre', 'bio', 'localisation', 'disponible'
        ]));

        return response()->json([
            'message' => 'Profil mis à jour avec succès',
            'data'    => $profil,
        ]);
    }
    // Ajouter une compétence
    public function addCompetence(Request $request)
    {
        $user = auth('api')->user();

        $profil = $user->profil;

        if (!$profil) {
            return response()->json([
                'message' => 'Vous n\'avez pas encore de profil'
            ], 404);
        }

        $request->validate([
            'competence_id' => 'required|exists:competences,id',
            'niveau'        => 'required|in:débutant,intermédiaire,expert',
        ]);

        if ($profil->competences->contains($request->competence_id)) {
            return response()->json([
                'message' => 'Cette compétence est déjà dans votre profil'
            ], 400);
        }

        $profil->competences()->attach($request->competence_id, [
            'niveau' => $request->niveau
        ]);

        return response()->json([
            'message' => 'Compétence ajoutée avec succès',
            'data'    => $profil->load('competences'),
        ], 201);
    }

    // Retirer une compétence
    public function removeCompetence(Competence $competence)
    {
        $user = auth('api')->user();

        $profil = $user->profil;

        if (!$profil) {
            return response()->json([
                'message' => 'Vous n\'avez pas encore de profil'
            ], 404);
        }

        if (!$profil->competences->contains($competence->id)) {
            return response()->json([
                'message' => 'Cette compétence n\'est pas dans votre profil'
            ], 404);
        }

        $profil->competences()->detach($competence->id);

        return response()->json([
            'message' => 'Compétence retirée avec succès',
        ]);
    }
}