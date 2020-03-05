<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
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
        return view('home', compact('recettes'));
    }
}
