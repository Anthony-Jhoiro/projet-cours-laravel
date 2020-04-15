<?php

namespace App\Http\Controllers;

use App\Events\NouvelleVisite;
use App\Recette;
use App\Categorie;
use App\User;
use App\visitors;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected $dateController;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(DateController $dateController)
    {
        $this->dateController = $dateController;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index( Request $request )
    {

        $recettesSuggerees = new Collection();
        $recettesAbonnements = new Collection();
        $recettes = [];
        if (isset($_GET['offset'])) $offset = $_GET['offset'];
        else $offset = 0;
        $size = 10;
        // Récupération de la liste des recettes
        if (isset( $_GET['filtre'] ) && !empty( $_GET['filtre'] )) {
            $recettes = Recette::where('titre', 'like', '%'.$_GET['filtre'].'%')->get();
        } else {
            $recettes = Recette::all();

            if (Auth::check ()) {
                // Chargement des recettes selon les préférences de l'utilisateur
                $curentUser = Auth::user ();
                $categories = $curentUser->getCategoriesPreferees;
                foreach ($categories as $category) {
                    $recettesSuggerees = $recettesSuggerees->merge(Recette::has ('getCategories', '=', $category->id)->get());
                }

                $suivis = $curentUser->getInfluencers;
                foreach ($suivis as $suivi) {
                    $recettesAbonnements = $recettesAbonnements->merge(Recette::where('auteur', $suivi->id)->get());
                }
            }
        }

        // on charge toutes les catégories pour le filtre par catégorie
        $cats = Categorie::all();


        // Pour chaque recette on formatte la date et on controlle la taille du texte
        foreach ($recettes as $recette) {
            $recette -> text = substr ( $recette -> text, 0, 100 ) . "...";
            $recette -> dateFormat = $this->dateController->getFormatDate ( $recette -> updated_at);
            $recette -> auteurNom = User::find($recette->auteur)->name;
        }

        foreach ($recettesSuggerees as $recette) {
            $recette -> text = substr ( $recette -> text, 0, 100 ) . "...";
            $recette -> dateFormat = $this->dateController->getFormatDate ( $recette -> updated_at);
            $recette -> auteurNom = User::find($recette->auteur)->name;
        }

        foreach ($recettesAbonnements as $recette) {
            $recette -> text = substr ( $recette -> text, 0, 100 ) . "...";
            $recette -> dateFormat = $this->dateController->getFormatDate ( $recette -> updated_at);
            $recette -> auteurNom = User::find($recette->auteur )->name;
        }

        event (new NouvelleVisite($request->ip ()));

        return view ( 'pages.home', [
            'recettes' => $recettes,
            'recettesSuggerees' => $recettesSuggerees,
            'recettesAbonnements' => $recettesAbonnements,
            'totalVisitors' => Visitors::sum('nbVisit'),
            'categories' => $cats
        ]);
    }
}
