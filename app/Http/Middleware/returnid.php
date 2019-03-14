<?php

namespace App\Http\Middleware;

use Closure;
use App\user;
use DB;

class returnid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    
    public function handle($request, Closure $next)
    {
        
        $remeber_token= DB::table('users')->where('remeber_token','=',$request->header('remeber_token') )->value('id');
        $id_token= DB::table('users')->where('id_token','=',$request->header('id_token') )->value('id');
       if ($remeber_token==$id_token) {
           $request->attributes->add(compact('remeber_token'));
        }
         
        return $next($request);
    }
}
