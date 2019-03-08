<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class workspace_user extends Model
{
	protected $table = 'workspace_users';
    protected $connection = 'mysql';
    protected $fillable = ['user_id','workspace_id'];


    public function user()
    {
        return $this->belongsTo('App\user');
    }
    public function user_role()
    {
        return $this->belongsTo('App\user_role');
    }
    public function workspace()
    {
        return $this->belongsTo('App\workspace');
    }
}
