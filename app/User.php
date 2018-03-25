<?php

namespace App;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements Authenticatable
{
	use \Illuminate\Auth\Authenticatable;
	public function posts(){
		return $this->hasMany('App\Post');
	}

	public function likes(){
    	return $this->hasMany('App\Like');
    }

    public function comments(){
		return $this->hasMany('App\Comment');
	}
    public function projects(){
        return $this->hasMany('App\Project');
    }
    public function pictures(){
        return $this->hasMany('App\Pictures');
    }
    public function primarypics(){
        return $this->hasMany('App\Pictures');
    }
    public function profile(){
        return $this->hasOne('App\PrimaryPics');
    }

    public function roles(){
    	return $this->belongsToMany('App\Role','user_role','user_id','role_id');
    }

    public function hasAnyRole($roles){
    	if(is_array($roles)){
    		foreach($roles as $role){
    			if($this->hasRole($role)){
    				return true;
    			}
    		}
    	}else{
    		if($this->hasRole($roles)){
    			return true;
    		}
    	}
    	return false;
    }

    public function hasRole($role){
    	if($this->roles()->where('name', $role)->first()){
    		return true;
    	}
    	return false;
    }
}