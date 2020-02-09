<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecetteRequest;
use App\Recette;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RecetteController extends Controller
{

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
        Recette::create([
            'titre' => $request->input ('titre'),
            'text' => $request->input ('text'),
            'auteur' => Auth::user ()->id
        ]);
        return view ('/');
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
