<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use App\user;
use App\workspace_user;
use DB;
use Illuminate\Support\Arr;

class userController extends Controller
{
    public function __construct()
    {
        // 所有 method 都會先經過 auth 這個 middleware
        $this->middleware('returnid');
 
        // 只有 create 會經過 auth 這個 middleware
      //  $this->middleware('auth',['only' => 'create']);
 
        // 除了 index 之外都會先經過 auth 這個 middleware
        //$this->middleware('returnid',['except' => 'checktoken','store']);
    }
    //顯示個人資料
    public function show(Request $request) 
    {    
        $id=$request->get('remeber_token');
        if(!empty($id)){
        $users = DB::table('users')
                     ->select('user_name', 'mobile','email')
                     ->where('id', '=', $id)
                     ->get();

            
            return response()->json([
            'profile' => $users,
            'status' => '1'
]);}
        else
             return response()->json([
            'status' => '0'
]);
    }
    //顯示個人蝦場
    public function showworkspace(Request $request) 
    {   
        $id=$request->get('remeber_token');
        if(!empty($id)){
        $user = DB::table('workspace_users')
                     ->select('user_id')
                     ->get();
        if(Arr::has($user, $id)==true){
        $users = DB::table('workspace_users')
                     ->select('workspace_id')
                     ->where('user_id', '=', $id)
                     ->get();
    
            
            return response()->json([
            'workspace_id' => $users,
            'status' => '1'
]); }
            else
                return response()->json([
            'error'=>'does not have workspace',
            'status' => '0'
]);

    }
    else
             return response()->json([
            'status' => '0'
]);
    }
}