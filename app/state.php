<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class state extends Model
{
    //
    protected $fillable = ['id','state_name'];

    public function field()
    {
        return $this->hasMany('App\field', 'foreign_key');
    }
}
