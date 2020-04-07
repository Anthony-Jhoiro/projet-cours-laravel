<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Recette;
use App\Categorie;

class CategorieController extends Controller
{
    public function getByRecette(Request $request, $id) {
        $recette = Recette::findOrFail($id);

        return $recette->getCategories;
    }

    public function store(IngredientRequest $request) {

        // test if ingredient exist in database
        $categories = Categorie::where (['libelle' => $request->get ('libelle')]);

        if ($categories->first() != NULL) {
            return;
        }

        // add the ingredient
        Categorie::create(['libelle' => $request->get ('libelle')]);

        return self::get ();

    }

    public function get() {
        return Categorie::all();
    }
}
