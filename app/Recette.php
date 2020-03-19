<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recette extends Model
{
    protected $fillable = [
        'titre',
        'text',
        'auteur',
        'maj',
        'ingredients',
        'assets',
        'formatDate'
    ];


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'recettes';


    public function getAssets()
    {
        return $this->hasMany('App\Assets');
    }


    public function getIngredients()
    {
        return $this->belongsToMany('App\Ingredients', 'recette_ingredient', 'id_recette', 'id_ingredient');
    }

    public function author() {
        return $this->belongsTo ('App\User', 'auteur', 'id');
    }

}
