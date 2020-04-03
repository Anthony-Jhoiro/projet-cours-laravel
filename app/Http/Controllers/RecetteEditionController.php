<?php

namespace App\Http\Controllers;

use App\Events\NouvelleRecette;
use App\Http\Requests\RecetteRequest;
use Illuminate\Http\Request;

use App\Recette;
use App\Ingredients;
use App\Assets;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RecetteEditionController extends Controller
{
    protected $homeController;

    public function __construct(HomeController $homeController){
        $this->homeController = $homeController;
    }

    /**
     * Créé la recette en base
     * @param RecetteRequest $request
     * @return mixed
     * @throws \Exception
     */
    public function store(RecetteRequest $request)
    {
        // Verification de l'unicité du titre
        $recette = Recette::where('titre', $request->titre)->get();
        if (count($recette) != 0) throw new \Exception("Le nom de la recette est déjà pris");

        // Creation de la recette en base
        $recette = new Recette([
            'titre' => $request->input ('titre'),
            'text' => $request->input ('text'),
            'auteur' => Auth::user ()->id
        ]);

        $recette -> save ();

        // Ajout des assets
        $photoUrls = $request->input('photoUrls');
        if ($photoUrls === null) $photoUrls = [];

        foreach ($photoUrls as $photoUrl) {
            Assets::create([
                'url' => $photoUrl,
                'recette_id' => $recette -> id
            ]);
        }

        $recette -> getIngredients () -> attach ($request -> ingredients);

        $recette -> getCategories () -> attach($request -> categories);

        // TODO : Envoie d'un mail à tout les utilisateurs qui suivent l'auteur

        event (new NouvelleRecette($recette));


        return $this->homeController->index( $request );
    }
}
