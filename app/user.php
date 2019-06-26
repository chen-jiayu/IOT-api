<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
class user extends Authenticatable implements JWTSubject
{
   
   // $fillable = ['user_name', 'citizen_id','password'];

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

