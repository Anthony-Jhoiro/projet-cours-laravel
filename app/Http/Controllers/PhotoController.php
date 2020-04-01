<?php

namespace App\Http\Controllers;

use App\Assets;
use App\Http\Requests\ImagesRequest;
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
}
