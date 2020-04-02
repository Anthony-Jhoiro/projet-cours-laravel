<?php

namespace App\Http\Controllers;

use App\Recette;
use App\visitors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    protected $dateController;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(DateController $dateController)
    {
        $this->dateController = $dateController;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index( Request $request )
    {
        // Récupération de la liste des recettes
        if (isset( $_GET['s'] ) && !empty( $_GET['s'] )) {
            $recettes = Recette::where('titre', 'like', '%'.$_GET['s'].'%')->limit(30)->get();
        } else {
            $recettes = Recette::limit(30)->get();
        }

        // Pour chaque recette on formatte la date et on controlle la taille du texte
        foreach ($recettes as $recette) {
            $recette -> text = substr ( $recette -> text, 0, 100 ) . "...";
            $recette -> dateFormat = $this->dateController->getFormatDate ( $recette -> updated_at);
        }

        // Controlle du nombre de visite
        // RULE : à chaque fois qu'un visiteur visite '/home', si sa dernière connexion
        // remonte à plus de 30min, on l'ajoute à la base de donnée
        $clientIp = $request -> ip();

        $visitor = visitors::where('ip', $clientIp)->orderBy('updated_at', 'desc')->first();
        if ($visitor != NULL) {
            // le visiteur est déjà venu
            if ($visitor->updated_at->diffInMinutes(now ()) > 30) {
                visitors::create(['ip' => $clientIp]);
            } else {
                $visitor->updated_at = now ();
                $visitor->save();
            }
        } else {
            // le visiteur est nouveau
            visitors::create(['ip' => $clientIp]);
        }

        return view ( 'home', [
            'recettes' => $recettes,
            'totalVisitors' => Visitors::count()
        ]);
    }
}
