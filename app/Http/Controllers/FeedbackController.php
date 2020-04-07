<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Feedback;
use App\User;

use Date;

class FeedbackController extends Controller
{
    public function __construct(DateController $dateController)
    {
        $this->dateController = $dateController;
    }

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

        $id = Auth::user()->id;
        $myNote = Feedback::where('recette_id', $recette_id)->where('user_id', $id)->get()[0]['note'];

        if($myNote == null) $myNote = 0;

        return $myNote;
    }

    public function storeCommentaire(Request $request){
        
        $recette_id = $request -> input('recette_id');
        $comm = $request -> input('comm');
        $user_id = Auth::user()->id;


        $newfeed = new Feedback([
            'user_id' => $user_id,
            'recette_id' => $recette_id,
            'note' => null,
            'commentaire' => $comm
        ]);

        log::debug(['commentaire' => $comm]);

        $feed = Feedback::where('user_id', $user_id) 
                        -> where('recette_id', $recette_id)
                        -> first();
        

        
        if($feed == NULL){
            $newfeed -> save();
        }
        else {
            $feed -> commentaire = $comm;
            $feed -> save();
        }

        $return = [
            'user' => Auth::user()->name,
            'commentaire' => $comm
        ];

        return $return;
    }

    public function indexCommentaires(Request $request, $recette_id){

        $comms = Feedback::where('recette_id', $recette_id)->whereNotNull('commentaire')->orderBy('updated_at', 'DESC')->get();

        $return = [];
        foreach($comms as $com){
            $user = User::select('name')->where('id', $com['user_id'])->first();
            $returncomm = [
            "user" => $user['name'],
            "commentaire" => $com["commentaire"],
            "date" => $this->dateController->getFormatDate ( $com['updated_at'])
            ];
            array_push($return, $returncomm);
        }

        return $return;
    }
}
