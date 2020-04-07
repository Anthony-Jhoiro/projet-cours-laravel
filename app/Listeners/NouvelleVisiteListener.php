<?php

namespace App\Listeners;

use App\visitors;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class NouvelleVisiteListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle( $event )
    {
        // Contrôle du nombre de visite
        // RULE : à chaque fois qu'un visiteur visite '/home', si sa dernière connexion
        // remonte à plus de 30min, on l'ajoute à la base de donnée
        $clientIp = $event -> ip;

        $visitor = visitors ::where ( 'ip', $clientIp ) -> orderBy ( 'updated_at', 'desc' ) -> first ();
        if ($visitor != NULL) {
            // le visiteur est déjà venu
            if ($visitor -> updated_at -> diffInMinutes ( now () ) > 30) {
                $visitor -> nbVisit++;
            }
            $visitor -> updated_at = now ();
            $visitor -> save ();
            Log::debug ($visitor);

        } else {
            // le visiteur est nouveau
            visitors ::create ( [ 'ip' => $clientIp ] );
        }
    }
}
