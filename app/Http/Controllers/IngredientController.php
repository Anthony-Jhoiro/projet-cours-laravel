<?php

namespace App\Http\Controllers;

use App\Ingredients;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function get() {
        return Ingredients::all();
    }
}
