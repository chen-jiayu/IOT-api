<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class user_role extends Model
{
    protected $table = 'user_roles';
    protected $connection = 'mysql';
    protected $fillable = ['role_name'];

    public function workspace_user()
    {
        return $this->hasMany('App\workspace_user', 'foreign_key');
    }
}
