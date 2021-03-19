<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class overall extends Model
{
    protected $fillable = ['user_id'];
    public function getUser() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
