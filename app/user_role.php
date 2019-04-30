<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class user_role extends Model
{
   
    protected $fillable = ['role_name'];

    public function workspace_user()
    {
        return $this->hasMany('App\workspace_user', 'foreign_key');
    }
}
