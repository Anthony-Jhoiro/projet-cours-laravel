<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recette extends Model
{
    protected $fillable = [
        'titre',
        'text',
        'auteur'
    ];
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'recettes';

    public function assets()
    {
        return $this->hasMany('App\Assets');
    }

}
