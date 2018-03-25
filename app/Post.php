<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
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
    public function tags(){
        return $this->belongsToMany('App\Tag','post_tags','post_id','tag_id');
    }
}
