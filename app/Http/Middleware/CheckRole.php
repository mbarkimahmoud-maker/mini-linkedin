<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        // On récupère l'utilisateur connecté via JWT
        $user = auth('api')->user();

        // Si pas connecté
        if (!$user) {
            return response()->json([
                'message' => 'Non authentifié'
            ], 401);
        }

        // Si le rôle de l'utilisateur n'est pas dans la liste des rôles autorisés
        if (!in_array($user->role, $roles)) {
            return response()->json([
                'message' => 'Accès refusé — rôle insuffisant'
            ], 403);
        }

        return $next($request);
    }
}