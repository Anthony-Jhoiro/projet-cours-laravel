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
        'assets'
    ];
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'recettes';

    public function __construct(string $titre, string $text, string $auteur, string $maj, array $ingredients, array $assets){
        $this->titre = $titre;
        $this->text = $text;
        $this->auteur = $auteur;
        $this->maj = $maj;
        $this->ingredients = $ingredients;
        $this->assets = $assets;
    }

    public function assets()
    {
        return $this->hasMany('App\Assets');
    }

    public function ingredients()
    {
        return $this->belongsToMany('App\Ingredients')
            ->using('App\IngredientsRecette')
            ->withPivot([
                'created_by',
                'updated_by'
            ]);
    }

}
