<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
class user extends Authenticatable implements JWTSubject
{
   
    protected $fillable = ['user_name', 'workspace_id','mobile', 'email', 'citizen_id','password', 'remeber_token','id_token'];

    public function workspace_user()
    {
        return $this->hasMany('App\workspace_user');
    }
    public function workspace()
    {
        return $this->hasMany('App\workspace');
    }
    public function getJWTIdentifier() {
    return $this->getKey();
}
    public function getJWTCustomClaims() {
    return [];
}
    

}

