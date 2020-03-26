<?php


namespace App;


use Illuminate\Database\Eloquent\Relations\Pivot;

class CategorieRecette extends Pivot
{
    protected $table = 'recette-categorie';
}
