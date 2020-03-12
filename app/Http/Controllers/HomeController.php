<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;

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
    public function index()
    {
        $recettes = DB::select('SELECT r.id, r.titre, r.auteur auteur_id, r.text, r.created_at, r.updated_at, u.name auteur FROM recettes r INNER JOIN users u ON r.auteur = u.id');
        foreach ($recettes as  $recette) {
            $recette->text = substr($recette->text, 0, HomeController::$nbCaractere)."...";
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $recette->updated_at);
            $moisNb = (int) $date->format('m') - 1;
            $mois = HomeController::$lesMois[$moisNb]." ";
            $jour = $date->format("d")." ";
            $reste = $date->format('Y à H:i');
            $recette->updated_at = $jour.$mois.$reste;
        }
        return view('home', compact('recettes'));
    }
}
