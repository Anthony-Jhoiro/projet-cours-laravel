<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecetteRequest;
use App\Recette;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RecetteController extends Controller
{

    public function create()
    {
        return view ('recetteEdit', ['typeFormulaire' => 'POST']);
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

    public function edit (Request $request) {
        // TODO : Pouvoir changer le type du formulaire (POST / PUT)
        $parametres = [
            'typeFormulaire' => 'POST'
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
