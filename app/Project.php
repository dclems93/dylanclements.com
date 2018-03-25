<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function sections(){
        return $this->hasMany('App\Section');
    }
    public function likes(){
        return $this->hasMany('App\Like');
    }
    public function primarypic(){
        return $this->hasOne('App\PrimaryPic');
    }
    public function tags(){
        return $this->belongsToMany('App\Tag','project_tags','project_id','tag_id');
    }
}
