<?php

namespace App\Http\Controllers;

use App\Assets;
use App\Http\Requests\RecetteRequest;
use App\Recette;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RecetteController extends Controller
{
    public function index(Request $request, $id){
        $recette = DB::select('SELECT r.id, r.titre, r.auteur auteur_id, r.text, r.created_at, r.updated_at, u.name auteur FROM recettes r INNER JOIN users u ON r.auteur = u.id WHERE r.id = ?', [$id]);
        $recette = $recette[0];
        return view('recette', compact('recette'));
    }

    public function create()
    {
        $parametres = [
            'typeFormulaire' => 'POST',
            'recette' => new Recette(),
            'id' => -1
        ];
        return view ('recetteEdit', $parametres);
    }

    public function store(RecetteRequest $request)
    {
        $recette = Recette::where('titre', $request->titre)->get();
        Log::debug ($recette);
        if (count($recette) != 0) throw new \Exception("Le nom de la recette est déjà pris");

        $recette = new Recette([
            'titre' => $request->input ('titre'),
            'text' => $request->input ('text'),
            'auteur' => Auth::user ()->id
        ]);
        $recette->save ();

        $photoUrls = $request->input('photoUrls');
        foreach ($photoUrls as $photoUrl) {
            Assets::create([
                'url' => $photoUrl,
                'recette' => $recette -> id
            ]);
        }
        return view ('home');
    }

    public function update(Request $request, $n)
    {

        Log::debug ("Update !");
        $recette = Recette::find($n);
        $recette->titre = $request->input ('titre');
        $recette->titre = $request->input ('text');
        $recette->save();
        return view ('home');
    }

    public function edit (Request $request, $n) {
        $recette = Recette::find($n);

        if (!isset($recette)) {
            abort(404);
        }
        $parametres = [
            'typeFormulaire' => 'PATCH',
            'recette' => $recette,
            'id' => $n
        ];
        return view ('recetteEdit', $parametres);
    }

    public function creer (Request $request) {
        // Vérifier les infos reçus
        $validator = Validator::make($request->all(), [
            'nom' => 'bail|required|between:5,20|alpha',
            'email' => 'bail|required|email',
            'message' => 'bail|required|max:250'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        return view('recetteEdit');


        // Ajouter les infos en base
    }

    public function modifier () {
        // Vérifier les infos reçus

        // Modifier les données en base
    }
}
