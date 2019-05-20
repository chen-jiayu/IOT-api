<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\workspace_user;
use App\workspace;
use App\user;
use App\user_role;
use App\field;
use App\pond;

use DB;
use Illuminate\Support\Arr;


class workspacesController extends Controller
{   
  public function __construct()
  {
    $this->middleware('returnid');
  }
    //修改正在使用蝦場
  public function show(Request $request)  
  {   
    try{
      DB::connection()->getPdo()->beginTransaction();
      $workspace=$request->header('workspace_id');
      $id=$request->get('remeber_token');
      if(!empty($id)){
        $user = user::find($id);
        if(empty($user)){
          return response()->json([
            'status' => '0',
            'code'=>2,
            'message'=>'data not found'
          ]);
        }       
        $user->workspace_id=$workspace;
        $user->save(); 
        DB::connection()->getPdo()->commit();         
        return response()->json([
          'status' => '1'
        ]);
      } else
      return response()->json([
        'status' => '0',
        'code'=>1,
        'message'=>'missing attrs'

      ]);                       
    } catch (\PDOException $e) {
      DB::connection()->getPdo()->rollBack();
      return response()->json([
        'status' => '0',
        'code'=>0,
        'message'=>$e->getMessage()

      ]);
    }
  }
     //建立養殖場，workspace_user新增
  public function store(Request $request)  
  {
    try{
      $this->validate($request,[
        'workspace_name'=>'required',
        'invite_code'=>'required'
      ]); 
      DB::connection()->getPdo()->beginTransaction();
      $id=$request->get('remeber_token');
      $name = DB::table('workspaces')->where('invite_code','=',$request->input('invite_code') )->value('invite_code');
      if(!empty($name)){
        return response()->json([
          'status' => '0',
          'code'=>3,
          'message'=>'data duplicate'
        ]);
      }
      if(!empty($id)){
       $workspace = new workspace();
       $workspace->user_id= $id;
       $workspace->workspace_name= $request->input('workspace_name');
       $workspace->invite_code= $request->input('invite_code');
       $workspace->save();

       $workspace_user = new workspace_user();
       $workspace_user->user_id=$id;
       $workspace_user->workspace_id=$workspace->id;
       $workspace_user->role_id='1';
       $workspace_user->save();



       $user=user::find($id);
       if(empty($user)){
        return response()->json([
          'status' => '0',
          'code'=>2,
          'message'=>'data not found'
        ]);
      }         
      $user->workspace_id=$workspace->id;
      $user->save();
      DB::connection()->getPdo()->commit();
      return response()->json([
        'result'=> $workspace->id,
        'status' => '1'
      ]); 
    } else
    return response()->json([
      'status' => '0',
      'code'=>1,
      'message'=>'missing attrs'

    ]);
  } catch (\PDOException $e) {
    DB::connection()->getPdo()->rollBack();
    return response()->json([
      'status' => '0',
      'code'=>0,
      'message'=>$e->getMessage()

    ]);
  }
}
  //加入養殖場
public function join(Request $request)  
{
  try{
    DB::connection()->getPdo()->beginTransaction();
    $id=$request->get('remeber_token');
    if(!empty($id)){
      $workspace_id = DB::table('workspaces')->where('invite_code','=',$request->input('invite_code'))->value('id');
      if(!empty($workspace_id)){
        $workspaceid = DB::table('workspace_users')->where('user_id','=',$id)->where('workspace_id','=',$workspace_id)->value('workspace_id');
        if(empty($workspaceid)){
         $workspace_user = new workspace_user();
         $workspace_user->user_id=$id;
         $workspace_user->workspace_id=$workspace_id;
         $workspace_user->role_id='2';
         $workspace_user->save();

         $user = user::find($id);
         $user->workspace_id=$workspace_user->workspace_id;
         $user->save();
         
         DB::connection()->getPdo()->commit();
         return response()->json([
          'status' => '1'
        ]);
       } else
       return response()->json([
        'status' => '0',
        'code'=>3,
        'message'=>'data duplicate'
      ]);
     }
     else
      return response()->json([
        'status' => '0',
        'code'=>2,
        'message'=>'data not found'
      ]);
  } else
  
  return response()->json([
    'status' => '0',
    'code'=>1,
    'message'=>'missing attrs'
  ]);
} catch (\PDOException $e) {
  DB::connection()->getPdo()->rollBack();
  return response()->json([
    'status' => '0',
    'code'=>0,
    'message'=>$e->getMessage()
  ]);
}
}
    //顯示蝦場資訊
public function get(Request $request) 
{   
  try{
    DB::connection()->getPdo()->beginTransaction();
    $id=$request->get('remeber_token');
    if(!empty($id)){
      $workspace_id = DB::table('users')->where('id','=',$id)->value('workspace_id');
      $work = DB::table('fields')
      ->where('fields.workspace_id', '=', $workspace_id)
      ->join('ponds', 'ponds.field_id', '=', 'fields.id')
      ->select('ponds.field_id','fields.field_name','ponds.id','ponds.pond_name')
      ->get();
      if(empty($work)){
        return response()->json([
          'status' => '0',
          'code'=>2,
          'message'=>'data not found'
        ]);
      }  
      DB::connection()->getPdo()->commit();
      return response()->json([
        'result' => $work,
        'status' => '1'
      ]); 
    }
    else
     return response()->json([
      'status' => '0',
      'code'=>1,
      'message'=>'missing attrs'
    ]);
 } catch (\PDOException $e) {
  DB::connection()->getPdo()->rollBack();
  return response()->json([
    'status' => '0',
    'code'=>0,
    'message'=>$e->getMessage()
  ]);
}
}
}