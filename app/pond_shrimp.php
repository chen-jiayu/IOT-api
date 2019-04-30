<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pond_shrimp extends Model
{
    //
     protected $fillable = ['workspace_id','pond_id','field_id','supplier_id','babysprimp','shrimp_type','number','density','start_date','end_date','note'];


    public function pond()
    {
        return $this->belongsTo('App\pond');
    }
}
