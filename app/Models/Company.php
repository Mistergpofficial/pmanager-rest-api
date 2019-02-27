<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
     protected $fillable = [
         'id',
    	'name', 
    	'description', 
    	'user_id'
	];

	

     public function user(){
        return $this->belongsTo('App\User');
    }

    public function projects(){
         return $this->hasMany('App\Models\Project');
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = strtoupper($value);
    }

    public function getDescriptionAttribute($value)
    {
        return strtolower($value);
    }

    public function comments()
    {
        return $this->morphMany('App\Models\Comments', 'commentable');
    }

}
