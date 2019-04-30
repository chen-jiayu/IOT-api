<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class field_feed_log extends Model
{
   
     public function field_feed()
    {
        return $this->hasMany('App\field_feed', 'foreign_key');
    }
     public function daily_note()
    {
        return $this->hasMany('App\daily_note', 'foreign_key');
    }
}
