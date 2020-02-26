<?php

namespace App\Http\Controllers;

use App\Assets;
use App\Http\Requests\ImagesRequest;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function store(ImagesRequest $request)
    {
        $path = $request->image->store(config('images.path'), 'public');

        return $path;
    }
}
