<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Feedback;

class FeedbackController extends Controller
{
    public function storeNote(Request $request){
        
        $recette_id = $request -> input('recette_id');
        $note = $request -> input('note');
        $user_id = Auth::user()->id;


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

        return $note;
    }

    public function indexNoteMoyenne(Request $request, $recette_id){

        log::debug('ok');
        
        $noteMoyenne = Feedback::where('recette_id', $recette_id)->avg('note');
        $noteMoyenne = round(intval($noteMoyenne));

        return $noteMoyenne;
    }

    public function indexMyNote(Request $request, $recette_id){

        log::debug(['recette : ' => $recette_id]);

        $id = Auth::user()->id;
        $myNote = Feedback::where('recette_id', $recette_id)->where('user_id', $id)->get()[0]['note'];

        return $myNote;
    }
}
