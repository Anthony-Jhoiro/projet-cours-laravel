<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class visitors extends Model
{
    protected $fillable = ['ip', 'updated_at'];

    protected $table = "visitors";
}
