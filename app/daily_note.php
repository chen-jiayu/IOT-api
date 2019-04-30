<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class daily_note extends Model
{
    //
    public function field_feed_log()
    {
        return $this->belongsTo('App\field_feed_log');
    }
}
