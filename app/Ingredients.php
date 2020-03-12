<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredients extends Model
{
    protected $table = 'ingredients';
    //


    public function recettes()
    {
        return $this->belongsToMany('App\Recette')
            ->using('App\IngredientsRecette')
            ->withPivot([
                'created_by',
                'updated_by'
            ]);
    }
}
