<?php

namespace App\Http\Controllers;

use App\Recette;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
        public static $lesMois = [ "janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre"];
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
    public function index(Request $request)
    {
        $recettes = Recette::all (); // TODO : Add offsets
        foreach ($recettes as  $recette) {
            $recette->text = substr($recette->text, 0, HomeController::$nbCaractere)."...";

            // TODO : Rework all of this
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $recette->updated_at);
            $moisNb = (int) $date->format('m') - 1;
            $mois = HomeController::$lesMois[$moisNb]." ";
            $jour = $date->format("d")." ";
            $reste = $date->format('Y à H:i');
            $recette->updated_att = $jour.$mois.$reste;
        }
        if ($recettes == null) Log::debug ($recettes);
        return view('home', compact('recettes'));
    }
}
