<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrimaryPic extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function project(){
        return $this->belongsTo('App\Project');
    }
    public function post(){
        return $this->belongsTo('App\Post');
    }
    public function section(){
        return $this->belongsTo('App\Section');
    }
}
