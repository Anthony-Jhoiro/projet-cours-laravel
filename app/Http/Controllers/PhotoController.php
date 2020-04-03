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
     */
    public function store(ImagesRequest $request)
    {
        $path = $request->image->store(config('images.path'), 'public');

        return $path;
    }

    public function getByRecette(Request $request, $id) {
        $recette = Recette::findOrFail($id);

        return $recette->getAssets;

    }
}
