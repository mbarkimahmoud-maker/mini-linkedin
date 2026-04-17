<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\StatutCandidatureMis;
use Illuminate\Support\Facades\Log;



class LogStatutCandidatureMis
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(StatutCandidatureMis $event ): void
    {
        
        $candidature  = $event->candidature;
        $ancienStatut = $event->ancienStatut;
        $nouveauStatut = $event->nouveauStatut;
        $date         = now()->format('d/m/Y H:i:s');

        Log::channel('candidatures')->info(
        "[$date] STATUT MODIFIÉ — Candidature ID: {$candidature->id} | Ancien: {$ancienStatut} -> Nouveau: {$nouveauStatut}"
        );
    }
}
