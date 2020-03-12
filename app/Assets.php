<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assets extends Model
{
    protected $fillable = [
        'url',
        'recette',
        'type'
    ];
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'assets';

    public function __construct(string $url, int $recette, string $type){
        $this->url = $url;
        $this->recette = $recette;
        $this->type = $type;
    }
}
