<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class supplier extends Model
{
    //
    protected $fillable = ['workspace_id', 'supplier_type','supplier_name','contact_name_1','contact_phone_1','contact_name_2','contact_phone_2','address','note'];

    public function field_feed()
    {
        return $this->hasMany('App\field_feed', 'foreign_key');
    }
    public function workspace()
    {
        return $this->belongsTo('App\workspace');
    }
}
