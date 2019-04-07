<?php

namespace App;

use App\grandpa;
use App\special;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
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

    public function special()
    {
        return $this->hasOne(special::class, 'user');
    }

    public function grandpa()
    {
        return $this->hasOne(grandpa::class, 'user');
    }
}
