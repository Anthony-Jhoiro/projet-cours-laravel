<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assets extends Model
{
    protected $fillable = [
        'url',
        'recette_id',
        'type'
    ];
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'assets';

}
