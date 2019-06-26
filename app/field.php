<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class field extends Model
{
	//protected $fillable = ['workspace_id','field_name','field_position','state_id'];
    
    public function pond()
    {
        return $this->hasMany('App\pond', 'foreign_key');
    }
    public function field_feed()
    {
        return $this->hasMany('App\field_feed', 'foreign_key');
    }
    public function workspace()
    {
        return $this->belongsTo('App\workspace');
    }
    public function state()
    {
        return $this->belongsTo('App\state');
    }

}
