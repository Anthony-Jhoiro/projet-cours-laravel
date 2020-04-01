<?php

namespace App\Http\Controllers;

use App\Cats_Prefs;
use App\Http\Requests\PreferencesCategoriesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PreferencesController extends Controller
{
    public function store(PreferencesCategoriesRequest $request) {
        $userId = Auth::user ()->id;
        $categorieId = $request->categorie_id;

        Log::debug ("User : ".$userId." | categorie : ".$categorieId);


        $previousResult = Cats_Prefs::where (['user_id' => $userId, 'categorie_id' => $categorieId])->first();
        Log::debug ("previousResults ".$previousResult);

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

            Log::debug ("result : ".$previousResult);
        }
    }

    public function storeForInjection($categorieId)
    {
        $userId = Auth ::user () -> id;

        Log ::debug ( "User : " . $userId . " | categorie : " . $categorieId );


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
