<?php

namespace App\Http\Controllers;

use App\Cats_Prefs;
use App\Http\Requests\PreferencesCategoriesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PreferencesController extends Controller
{
    /**
     * Au moment d'une visite d'un tilisateur sur la page d'une recette, mémorise
     * les catégories de la recette en base afin d'y accéder en priorité
     * @param PreferencesCategoriesRequest $request
     */
    public function store(PreferencesCategoriesRequest $request) {
        $userId = Auth::user ()->id;
        $categorieId = $request->categorie_id;


        $previousResult = Cats_Prefs::where (['user_id' => $userId, 'categorie_id' => $categorieId])->first();

        if ($previousResult == Null) {
            Cats_Prefs::create([
                'user_id' => $userId,
                'categorie_id' => $categorieId,
                'derniere_visite' => now (),
                'nb_visite' => 1
            ]);
        } else {
            $previousResult->update([
                'derniere_visite' => now (),
                'nb_visite' => $previousResult->nb_visite+1
            ]);
        }
    }

    /**
     * Même foction qu'au dessus mais avec directement l'id de la categorie en parametre
     * @param $categorieId
     */
    public function storeForInjection($categorieId)
    {
        $userId = Auth ::user () -> id;

        $previousResult = Cats_Prefs ::where ( [ 'user_id' => $userId, 'categorie_id' => $categorieId ] ) -> first ();

        if ($previousResult == Null) {
            Cats_Prefs ::create ( [
                'user_id' => $userId,
                'categorie_id' => $categorieId,
                'derniere_visite' => now (),
                'nb_visite' => 1
            ] );
        } else {
            $previousResult -> update ( [
                'derniere_visite' => now (),
                'nb_visite' => $previousResult -> nb_visite + 1
            ] );
        }
    }
}
