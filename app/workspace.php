<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class workspace extends Model
{
    protected $table = 'workspaces';
    protected $connection = 'mysql';
    protected $fillable = ['workspace_name', 'invite_code','mobile','status','created_id','update_id'];


    public function workspace_user()
    {
        return $this->hasMany('App\workspace_user', 'foreign_key');
    }
    public function option()
    {
        return $this->hasMany('App\option', 'foreign_key');
    }

    
}
