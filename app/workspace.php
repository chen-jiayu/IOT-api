<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class workspace extends Model
{
   
    protected $fillable = ['workspace_name', 'invite_code','mobile','status','created_id','update_id','user_id'];
    
    public function user()
    {
        return $this->belongsTo('App\user');
    }

    public function workspace_user()
    {
        return $this->hasMany('App\workspace_user', 'foreign_key');
    }
    public function option()
    {
        return $this->hasMany('App\option', 'foreign_key');
    }
    public function field()
    {
        return $this->hasMany('App\field', 'foreign_key');

    }
    public function supplier()
    {
        return $this->hasMany('App\supplier', 'foreign_key');
    }

    
}
