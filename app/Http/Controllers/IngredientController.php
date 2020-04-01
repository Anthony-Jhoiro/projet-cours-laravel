<?php

namespace App\Http\Controllers;

use App\Http\Requests\IngredientRequest;
use App\Ingredients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IngredientController extends Controller
{
    public function get() {
        return Ingredients::all();
    }

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
}
