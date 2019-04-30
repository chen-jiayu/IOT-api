<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class field_feed extends Model
{
    //

    // public function field_feed_log()
    // {
    //     return $this->hasMany('App\field_feed_log', 'foreign_key');
    // }
    public function supplier()
    {
        return $this->belongsTo('App\supplier');
    }

    public function field()
    {
        return $this->belongsTo('App\field');
    }
    
}
