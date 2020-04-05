<?php

namespace App\Http\Controllers;

use App\Assets;
use App\Http\Requests\ImagesRequest;
use App\Recette;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    /**
     * ajoute les images au stockage
     * @param ImagesRequest $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(ImagesRequest $request)
    {
        $this->validate($request, [
            'photo' => 'mimes:jpeg,png,bmp,tiff |max:4096',
        ],
            $messages = [
                'required' => 'Le champ :attribute est requis.',
                'mimes' => 'Seules les images jpeg, png, bmp,tiff sont autorisées.'
            ]
        );

        return $request->image->store(config('images.path'), 'public');
    }

    public function getByRecette(Request $request, $id) {
        $recette = Recette::findOrFail($id);

        return $recette->getAssets;

    }
}
