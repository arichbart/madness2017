<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class team extends Model
{
	public function grandpa() {
		return $this->hasMany('App\grandpa', 'id', 'top_left_team');
	}
    
}
