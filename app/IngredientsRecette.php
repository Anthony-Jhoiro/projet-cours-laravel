<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class IngredientsRecette extends Pivot
{
    protected $table = 'recette_ingredient';

}
