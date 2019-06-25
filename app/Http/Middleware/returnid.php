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

        $remeber_token= DB::table('users')->where('remeber_token','=',$request->header('remeber_token'))->where('id_token','=',$request->header('id_token') )->value('id');
        $count= DB::table('users')->where('remeber_token','=',$request->header('remeber_token'))->where('remeber_token','=',$request->header('remeber_token'))->count();
        
      

        if ($count!= 0 ) {
         $request->attributes->add(compact('remeber_token'));

         return $next($request);
     }

    if($request->header('remeber_token')== ''||$request->header('id_token')== ''){
      return response()->json([
            'status'=>'0',
            'code'=>1,
            'message'=> 'missing attribute'

        ]);
    }

    else
        return response()->json([
            'status'=>'0',
            'code'=>4,
            'message'=> 'token invalid'
        ]);

      //  return $next($request);
}
}
