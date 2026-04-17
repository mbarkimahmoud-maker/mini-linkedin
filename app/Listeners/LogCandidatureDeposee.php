<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\CandidatureDeposee;
use Illuminate\Support\Facades\Log;


class LogCandidatureDeposee
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
    public function handle(CandidatureDeposee $event ): void
    {
        $candidature = $event->candidature;

        $nomCandidat  = $candidature->profil->user->name;
        $titreOffre   = $candidature->offre->titre;
        $date         = now()->format('d/m/Y H:i:s');

        Log::channel('candidatures')->info(
        "[$date] NOUVELLE CANDIDATURE — Candidat: $nomCandidat | Offre: $titreOffre"
        );
    }
}
