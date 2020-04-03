<?php

namespace App\Http\Controllers;

use App\Http\Requests\IngredientRequest;
use App\Ingredients;
use App\Recette;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IngredientController extends Controller
{
    public function get() {
        return Ingredients::all();
    }

    /**
     * si l'ingrédient n'existe pas, le créer
     * @param IngredientRequest $request
     * @return Ingredients[]|\Illuminate\Database\Eloquent\Collection|void
     */
    public function store(IngredientRequest $request) {

        // test if ingredient exist in database
        $ingredients = Ingredients::where (['libelle' => $request->get ('libelle')]);

        if ($ingredients->first() != NULL) {
            return;
        }

        // add the ingredient
        Ingredients::create(['libelle' => $request->get ('libelle')]);

        return self::get ();

    }

    public function getByRecette(Request $request, $id) {
        $recette = Recette::findOrFail($id);

        return $recette->getIngredients;
    }
}
