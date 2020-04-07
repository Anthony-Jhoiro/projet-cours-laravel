<?php

namespace App\Http\Controllers;

use App\Recette;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{

    protected $dateController;

    /**
     * Create a new controller instance.
     *
     * @param DateController $dateController
     */
    public function __construct(DateController $dateController)
    {
        $this->dateController = $dateController;
    }

    /**
     * Génère la page de profil de l'utilisateur courant
     * @return Factory|View
     */
    public function index() {
        $parameters = [];

        // Get users informations
        $parameters['user'] = Auth::user ();

        // Récupérer les recettes du user et mise en forme
        $parameters['recettes'] = Recette::where('auteur', $parameters['user']->id)->get();
        foreach ($parameters['recettes'] as $recette) {
            $recette->parsedText = substr ( $recette -> text, 0, 100 ) . "...";
            $recette -> formatDate = $this->dateController->getFormatDate ( $recette -> updated_at);
        }

        // Récupérer nombre de followers
        $parameters['followers'] = $parameters['user'] -> getFollowers -> count ();

        //Récupérer la liste des auteurs suivis
        $parameters['auteursSuivis'] = $parameters['user'] -> getInfluencers ;

        return view ('profile', $parameters);
    }

}
