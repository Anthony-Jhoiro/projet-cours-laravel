<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Recette;
use App\Ingredients;

class RecetteEditionController extends Controller
{
    public function store(RecetteRequest $request)
    {
        // Vérification de l'unicité du titre
        $recette = Recette::where('titre', $request->titre)->get();
        if (count($recette) != 0) throw new \Exception("Le nom de la recette est déjà pris");

        // Création de la recette en base
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

        // Ajout des ingredients
        $recette -> getIngredients () -> attach ($request -> ingredients);

        $recette -> getCategories () -> attach($request -> categories);

        // TODO : Envoie d'un mail à tout les utilisateurs qui suivent l'auteur


        return self::index ();
    }
}
