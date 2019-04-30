<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pond extends Model
{
    //
    protected $fillable = ['workspace_id','state_name','field_id','pond_name','long','depth','width','waterwheel'];

    public function pond_shrimp()
    {
        return $this->hasMany('App\pond_shrimp', 'foreign_key');
    }
    public function field()
    {
        return $this->belongsTo('App\field');
    }
}
