<?php

namespace App\Http\Controllers;

use App\Http\Requests\SocialRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SocialController extends Controller
{
    public function follow(SocialRequest $request) {
        try {
            $currentUser = User::find(Auth::user ()->id);
            $currentUser->getFollowers() -> attach ($request -> id);
            return "Vous êtes abonné !";
        } catch (\Exception $e) {
            return $e->getMessage ();
        }

    }
}

