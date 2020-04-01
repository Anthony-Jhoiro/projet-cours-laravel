<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredients extends Model
{
    protected $fillable = [
        'libelle'
    ];

    protected $table = 'ingredients';

    protected $fillable = [
        'libelle'
    ];


    public function recettes()
    {
        return $this->belongsToMany('App\Recette', 'recette_ingredient', 'id_ingredient', 'id_recette');
    }
}
