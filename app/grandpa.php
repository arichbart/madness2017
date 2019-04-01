<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class grandpa extends Model
{
    protected $guarded = [];
    
    public function team1() {
    	return $this->belongsTo('App\team', 'top_left_team', 'id');
    }
    public function team2() {
    	return $this->belongsTo('App\team', 'bottom_left_team', 'id');
    }
    public function team3() {
    	return $this->belongsTo('App\team', 'top_right_team', 'id');
    }
    public function team4() {
    	return $this->belongsTo('App\team', 'bottom_right_team', 'id');
    }
    public function getUser() {
        return $this->belongsTo('App\User', 'user', 'id');
    }
}
