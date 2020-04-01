<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredients extends Model
{
    protected $fillable = [
        'libelle'
    ];

    protected $table = 'ingredients';


    public function recettes()
    {
        return $this->belongsToMany('App\Recette', 'recette_ingredient', 'id_ingredient', 'id_recette');
    }
}
