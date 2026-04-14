<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offre;

class OffreController extends Controller
{
    // Afficher la liste des offres actives
    public function index(Request $request)
    {
        $query = Offre::where('actif', true)
                      ->orderBy('created_at', 'desc');

        if ($request->has('localisation')) {
            $query->where('localisation', 'like', '%' . $request->localisation . '%');
        }

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        $offres = $query->paginate(10);

        return response()->json([
            'message' => 'Liste des offres',
            'data'    => $offres,
        ]);
    }

    // Afficher les détails d'une offre
    public function show(Offre $offre)
    {
        return response()->json([
            'message' => 'Détail de l\'offre',
            'data'    => $offre,
        ]);
    }

    //  Créer une offre par le recruteur
    public function store(Request $request)
    {
        $request->validate([
            'titre'        => 'required|string|max:255',
            'description'  => 'required|string',
            'localisation' => 'required|string|max:255',
            'type'         => 'required|in:CDI,CDD,stage',
        ]);

        $offre = Offre::create([
            'user_id'      => auth('api')->id(),
            'titre'        => $request->titre,
            'description'  => $request->description,
            'localisation' => $request->localisation,
            'type'         => $request->type,
            'actif'        => true,
        ]);

        return response()->json([
            'message' => 'Offre créée avec succès',
            'data'    => $offre,
        ], 201);
    }

    // Modifier une offre par le recruteur
    public function update(Request $request, Offre $offre)
    {
        if ($offre->user_id !== auth('api')->id()) {
            return response()->json([
                'message' => 'Vous n\'êtes pas autorisé à modifier cette offre'
            ], 403);
        }

        $request->validate([
            'titre'        => 'sometimes|string|max:255',
            'description'  => 'sometimes|string',
            'localisation' => 'sometimes|string|max:255',
            'type'         => 'sometimes|in:CDI,CDD,stage',
        ]);

        $offre->update($request->only([
            'titre', 'description', 'localisation', 'type'
        ]));

        return response()->json([
            'message' => 'Offre mise à jour avec succès',
            'data'    => $offre,
        ]);
    }

    // Supprimer une offre par le recruteur proprio
    public function destroy(Offre $offre)
    {
        if ($offre->user_id !== auth('api')->id()) {
            return response()->json([
                'message' => 'Vous n\'êtes pas autorisé à supprimer cette offre'
            ], 403);
        }

        $offre->delete();

        return response()->json([
            'message' => 'Offre supprimée avec succès',
        ]);
    }
}