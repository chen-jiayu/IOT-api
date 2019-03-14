<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class field extends Model
{
    //
    public function state()
    {
        return $this->belongsTo('App\state');
    }
    public function workspace()
    {
        return $this->belongsTo('App\workspace');
    }

     
    public function pond()
    {
        return $this->hasMany('App\pond', 'foreign_key');
    }

}
