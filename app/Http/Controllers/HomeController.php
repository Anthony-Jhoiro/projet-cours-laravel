<?php

namespace App\Http\Controllers;

use App\Recette;
use App\visitors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public static $lesMois = [ "janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre" ];
    public static $nbCaractere = 100;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index( Request $request )
    {
        // TODO : Rework !!!!
        if (isset( $_GET['s'] ) && !empty( $_GET['s'] )) {
            $filtre = $_GET['s'];
            $recettes = Recette::where('titre', 'like', '%'.$_GET['s'].'%')->limit(30)->get();
        } else {
            $recettes = Recette::limit(30)->get();
        }

        foreach ($recettes as $recette) {
            $recette -> text = substr ( $recette -> text, 0, HomeController ::$nbCaractere ) . "...";

            // TODO : Rework all of this
            $date = DateTime ::createFromFormat ( 'Y-m-d H:i:s', $recette -> updated_at );
            $moisNb = (int)$date -> format ( 'm' ) - 1;
            $mois = HomeController ::$lesMois[$moisNb] . " ";
            $jour = $date -> format ( "d" ) . " ";
            $reste = $date -> format ( 'Y à H:i' );
            $recette -> updated_att = $jour . $mois . $reste;
        }

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
