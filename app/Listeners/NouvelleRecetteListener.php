<?php

namespace App\Listeners;

use App\Mail\NewPostMail;
use App\Recette;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NouvelleRecetteListener
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        // Envoie d'un mail à tout les utilisateurs qui suivent l'auteur de la recette
        $auteur = Auth::user();

        $followers = $auteur->getFollowers;

        foreach ($followers as $follower) {
            Mail::to ($follower->email)->send (new NewPostMail($event->recette, $auteur));
        }
    }
}
