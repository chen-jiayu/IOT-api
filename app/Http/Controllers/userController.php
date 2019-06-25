<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Collection;
use App\user;
use App\workspace_user;
use App\workspace;
use App\user_role;
use DB;
use Illuminate\Support\Arr;

class userController extends Controller
{
  public function __construct()
  {
    $this->middleware('returnid');
  }
    //顯示個人資料
  public function show(Request $request) 
  {    
    try{
      
      $id=$request->get('remeber_token');

       $user = user::find($id);
       $workspace=workspace::find($user->workspace_id);
       if(count($user)==0&&count($workspace==0)){
        return response()->json([
          'status' => '0',
          'code'=>2,
          'message'=>'data not found'
        ]);
      }
      if(!empty($workspace->id)){
       $role_id= DB::table('workspace_users')->where('workspace_id', '=',$workspace->id)->value('role_id');
       $user_role=user_role::find($role_id);
       if(count($role_id)==0){
        return response()->json([
          'status' => '0',
          'code'=>2,
          'message'=>'data not found'
        ]);
      }

      $result = array(
        'user_name' => $user->user_name,
        'mobile' => $user->mobile,
        'email' => $user->email,
        'workspace'=>array(
          'workspace_id' => $workspace->id,
          'workspace_name' => $workspace->workspace_name,
          'invite_code' => $workspace->invite_code,
          'mobile' => $user->mobile,
          'role_id' => $user_role->id,
          'role_name' => $user_role->role_name,
          'status' => $workspace->status
        )
      ); 
    
      return response()->json([
        'result' => $result ,
        'status' => '1',

      ]);
    }
      else
        $result = array(
          'user_name' => $user->user_name,
          'mobile' => $user->mobile,
          'email' => $user->email,
          'workspace'=>'null'
        );
     
      return response()->json([
        'result' => $result ,
        'status' => '1'
      ]);
    
  } catch (\PDOException $e) {
   
    return response()->json([
      'status' => '0',
      'code'=>0,
      'message'=>$e->getMessage()
    ]);
  }
}
    //顯示個人蝦場
public function showworkspace(Request $request) 
{   
  try{
   
    $id=$request->get('remeber_token');
    
    $user= DB::table('workspace_users')->where('user_id', '=',$id)->get();
      
      if(count($user)!=0){
        $users = DB::table('workspace_users')
        ->join('workspaces', 'workspace_users.workspace_id', '=', 'workspaces.id')
        ->where('workspace_users.user_id', '=', $id)
        ->join('users', 'users.id', '=', 'workspaces.user_id')
        ->select('workspaces.workspace_name','workspace_users.workspace_id')
        ->get();

        return response()->json([
          'result' => $users,
          'status' => '1'
        ]); } else
        return response()->json([
          'status' => '0',
          'code'=>2,
          'message'=>'data not found'
        ]);
      
    } catch (\PDOException $e) {
      
      return response()->json([
        'status' => '0',
        'code'=>0,
        'message'=>$e->getMessage()
      ]);
    }
  }
}