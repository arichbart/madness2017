<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class overall extends Model
{
    public function getUser() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
