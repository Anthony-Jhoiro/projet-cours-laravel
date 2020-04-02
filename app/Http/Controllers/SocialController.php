<?php

namespace App\Http\Controllers;

use App\Http\Requests\SocialRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SocialController extends Controller
{
    /**
     * Ajoute l'utilisateur courant aux "suiveurs" de l'utilisateur donné d ans la requete
     * @param SocialRequest $request
     * @return string
     */
    public function follow(SocialRequest $request) {
        try {
            $currentUser = User::find(Auth::user ()->id);
            $currentUser->getInfluencers() -> attach ($request -> id);
            return "Vous êtes abonné !";
        } catch (\Exception $e) {
            return $e->getMessage ();
        }

    }

    public function unFollow(Request $request, $id) {
        $user = User::findOrFail($id);
        $user->getFollowers()->detach(Auth::user ()->id);

    }
}

