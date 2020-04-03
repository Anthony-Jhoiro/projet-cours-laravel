<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Feedback;

class FeedbackController extends Controller
{
    public function storeNote(Request $request){
        
        $recette_id = $request -> input('recette_id');
        $note = $request -> input('note');
        $user_id = Auth::user() -> id;

        $newfeed = new Feedback([
            'user_id' => $user_id,
            'recette_id' => $recette_id,
            'note' => $note,
            'commentaire' => null
        ]);

        

        $feed = Feedback::where('user_id', $user_id) 
                        -> where('recette_id', $recette_id)
                        -> first();
        
        if($feed == NULL){
            $newfeed -> save();
        }
        else {
            $feed -> note = $note;
            $feed -> save();
        }
    }
}
