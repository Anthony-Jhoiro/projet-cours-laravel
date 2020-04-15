<?php

namespace App;


use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, $id)
 */
class Recette extends Model
{
    protected $fillable = [
        'titre',
        'text',
        'auteur',
        'maj',
        'ingredients',
        'categories',
        'assets',
        'formatDate',
        'auteurNom'
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

    public function getCategories() {
        return $this -> belongsToMany ('App\Categorie', 'recette_categorie', 'id_recette', 'id_categorie');
    }

    public function author() {
        return $this->belongsTo ('App\User', 'auteur', 'id');
    }
}
