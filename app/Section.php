<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    public function project(){
        return $this->belongsTo('App\Project');
    }
    public function likes(){
        return $this->hasMany('App\Like');
    }
    public function comments(){
        return $this->hasMany('App\Comment');
    }
    public function primarypic(){
        return $this->hasOne('App\PrimaryPic');
    }
}
