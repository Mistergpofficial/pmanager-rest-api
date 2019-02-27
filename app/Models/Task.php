<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
     protected $fillable = ['name', 'days', 'hours', 'project_id','user_id',
    	'company_id'
	
	];

	 public function project(){
        return $this->belongsTo('App\Models\Project');
    }

     public function user(){
        return $this->belongsTo('App\User');
    }

     public function company(){
        return $this->belongsTo('App\Models\Company');
    }

     public function users(){
        return $this->belongsToMany('App\User');
    }

    public function comments()
    {
        return $this->morphMany('App\Models\Comments', 'commentable');
    }

}

