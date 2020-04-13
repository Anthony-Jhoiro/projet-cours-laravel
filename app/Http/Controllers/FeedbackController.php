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

    public function storeNote(Request $request){ // appelée quand un utilisateur donne une note

        // récupération des valeurs pour l'insertion en base de donnée d'une note
        $recette_id = $request -> input('recette_id');
        $note = $request -> input('note');
        $user_id = Auth::user()->id;


        $newfeed = new Feedback([ // on crée un model de la note que l'on va insérer
            'user_id' => $user_id,
            'recette_id' => $recette_id,
            'note' => $note,
            'commentaire' => null
        ]);

        $feed = Feedback::where('user_id', $user_id) // on vérifie si le champ existe déjà
                        -> where('recette_id', $recette_id)
                        -> first();



        if($feed == NULL){ // s'il existe pas, on en crée un
            $newfeed -> save();
        }
        else { // il existe, on modifie la note
            $feed -> note = $note;
            $feed -> save();
        }

        return $note;
    }

    public function indexNoteMoyenne(Request $request, $recette_id){ // appelée pour rechercher la note moyenne donnée pour une recette

        // on récupère la note moyenne que l'on arrondi
        $noteMoyenne = Feedback::where('recette_id', $recette_id)->whereNotNull('note')->avg('note');
        $noteMoyenne = round(intval($noteMoyenne));

        return $noteMoyenne;
    }

    public function indexMyNote(Request $request, $recette_id){ // récupérer la note qu'un utilisateur a donné à la recette

        // on recherche dans la base de donnée la note
        $id = Auth::user()->id;
        $myNote = Feedback::where('recette_id', $recette_id)->where('user_id', $id)->get();
        if(count($myNote) != 0){ // s'il y en a une, on la récupère
            $myNote = $myNote[0]['note'];
        }

        if($myNote == null) $myNote = 0; // sinon la note affichée est 0

        return $myNote;
    }

    public function storeCommentaire(Request $request){ // appelée lorsque l'utilisateur donne un commentaire

        // on récupère les données en vu de l'insertion
        $recette_id = $request -> input('recette_id');
        $comm = $request -> input('comm');
        $user_id = Auth::user()->id;

        // on crée un model de commentaire
        $newfeed = new Feedback([
            'user_id' => $user_id,
            'recette_id' => $recette_id,
            'note' => null,
            'commentaire' => $comm
        ]);
        
        // on regarde si le model existe déjà en base
        $feed = Feedback::where('user_id', $user_id)
                        -> where('recette_id', $recette_id)
                        -> first();



        if($feed == NULL){ // s'il n'existe pas, on le crée
            $newfeed -> save();
        }
        else { // sinon on modifie l'existant
            $feed -> commentaire = $comm;
            $feed -> save();
        }

        $return = [
            'user' => Auth::user()->name,
            'commentaire' => $comm
        ];

        return $return;
    }

    public function indexCommentaires(Request $request, $recette_id){ // appelée pour rechercher tous les commentaires liées à une recette

        // on effectue la recherche en bdd
        $comms = Feedback::where('recette_id', $recette_id)->whereNotNull('commentaire')->orderBy('updated_at', 'DESC')->get();

        $return = [];
        // on formate la réponse sous cette forme : utilisateur, commentaire, date du commentaire
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
