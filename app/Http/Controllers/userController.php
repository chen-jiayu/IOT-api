<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use App\user;
use App\workspace_user;
use DB;
//use App\workspace_user;

class userController extends Controller
{
    public function index()
    {
       
        return user::all();                    //檢索所有資料
    }

    public function show($user) //檢索單筆資料
    {
        $users = DB::table('users')
                     ->select('user_name', 'mobile','email','password')
                     ->where('id', '=', $user)
                     ->get();

                     // return $users;   
                      return response()->json([
            'id_token' => $users,
            'status' => '1'
]);
    }

    public function showworkspace($user) 
    {
        $users = DB::table('workspace_users')
                     ->select('workspace_id')
                     ->where('user_id', '=', $user)
                     ->get();

                      return $users;  
                      return response()->json([
            'id_token' => $users,
            'status' => '1'
]); 
    }

  
   
    public function update(Request $request, user $user)
    {
        $user->update($request->all());

        return response()->json($user, 200);   //資料更新，回傳200代表OK
    }
    
    public function delete(user $user)
    {
        $user->delete();

        return response()->json(null, 204);    //資料刪除，回傳204代表動作成功執行不回傳內容
    }


}