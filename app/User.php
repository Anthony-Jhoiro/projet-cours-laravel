<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @method static find($id)
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $table = 'users';

    public function getCategoriesPreferees() {
        return $this->belongsToMany ('App\Categorie', 'cats_prefs', 'user_id', 'categorie_id');
    }


    public function getFollowers() {
        return $this->belongsToMany('App\User', 'abonner', 'abonne', 'suivi');
    }

    public function getInfluencers() {
        return $this->belongsToMany('App\User', 'abonner', 'suivi', 'abonne');
    }
}
