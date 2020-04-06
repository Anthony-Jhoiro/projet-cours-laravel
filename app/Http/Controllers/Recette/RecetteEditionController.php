<?php

namespace App\Http\Controllers\Recette;

use App\Http\Controllers\Controller;
use App\Categorie;
use App\Ingredients;
use App\Recette;
use Illuminate\Http\Request;

class RecetteEditionController extends Controller
{

    /**
     * Charge la page d'édition d'une recette en mode création
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $parametres = [
            'typeFormulaire' => 'POST',
            'recette' => new Recette(),
            'id' => -1,
            'categories' => Categorie::all(),
            'ingredients' => Ingredients::all (),
            'categoriesSelectionnes' => [],
            'assets' => []
        ];

        return view ('recetteEdit', $parametres);
    }

    /**
     * Charge la page d'édition d'une recette en mode edition
     * @param Request $request
     * @param $n
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit (Request $request, $n) {
        $recette = Recette::findOrFail($n);

        $ingredients = $recette->getIngredients;

        $assets = $recette->getAssets;

        $categories = $recette->getCategories->toArray();

        $categories = array_map (function ($e) {
            return $e['id'];
        }, $categories);

        $parametres = [
            'typeFormulaire' => 'PATCH',
            'recette' => $recette,
            'assets' => $assets,
            'ingredients' => $ingredients,
            'categories' => Categorie::all(),
            'categoriesSelectionnes' => $categories,
            'id' => $n
        ];

        return view ('recetteEdit', $parametres);
    }

}
