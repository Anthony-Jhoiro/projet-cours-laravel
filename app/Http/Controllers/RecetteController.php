<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RecetteController extends Controller
{

    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        //
    }

    public function edit (Request $request) {
        // TODO : Pouvoir changer le type du formulaire (POST / PUT)
        $parametres = [
            'typeFormulaire' => 'POST'
        ];

        if ($request -> ajax () ) {
            return view('recetteEdit', $parametres)
                -> renderSections();
        }
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
