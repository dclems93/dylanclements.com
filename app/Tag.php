<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function projects(){
        return $this->belongsToMany('App\Project','project_tags','tag_id','project_id');
    }
    public function posts(){
        return $this->belongsToMany('App\Post','post_tags','tag_id','post_id');
    }
}
