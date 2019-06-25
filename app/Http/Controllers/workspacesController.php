<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
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
      $workspace=$request->input('workspace_id');
      $id=$request->get('remeber_token');
      $user = user::find($id);
      $count=DB::table('workspace_users')->where('workspace_id', '=',$workspace)->where('user_id', '=',$id)->count();

      if($count>0){      
        $user->workspace_id=$workspace;
        $user->save(); 
        DB::connection()->getPdo()->commit();         
        return response()->json([
          'status' => '1'
        ]);
      }
      else
        return response()->json([
          'status' => '0',
          'code'=>2,
          'message'=>'data not found'
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
      //$name = DB::table('workspaces')->where('invite_code','=',$request->input('invite_code') )->value('invite_code');
      $count = DB::table('workspaces')->where('invite_code','=',$request->input('invite_code'))->count();
      if($count!=0){
        return response()->json([
          'status' => '0',
          'code'=>3,
          'message'=>'data duplicate'
        ]);
      }
      $workspace = new workspace();
      $workspace->user_id= $id;
      $workspace->workspace_name= $request->input('workspace_name');
      $workspace->invite_code= $request->input('invite_code');
      $workspace->status= '1';
      $workspace->save();

      $workspace_user = new workspace_user();
      $workspace_user->user_id=$id;
      $workspace_user->workspace_id=$workspace->id;
      $workspace_user->role_id='1';
      $workspace_user->save();

      $count1=DB::table('users')->where('id', '=',$id)->count();
      $user=user::find($id);
      if($count1==0){
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
      $workspace_id = DB::table('workspaces')->where('invite_code','=',$request->input('invite_code'))->value('id');
      if($workspace_id>0){
        $workspaceid = DB::table('workspace_users')->where('user_id','=',$id)->where('workspace_id','=',$workspace_id)->value('workspace_id');
        if($workspace_id>0){
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

    $id=$request->get('remeber_token');

    $workspace_id = DB::table('users')->where('id','=',$id)->value('workspace_id');
    $field_id = DB::table('fields')->where('workspace_id','=',$workspace_id)->get();
    //$count=DB::table('ponds')->where('workspace_id','=',$workspace_id)->count();

    if(count($field_id)==0){
      return response()->json([
        'status' => '0',
        'code'=>2,
        'message'=>'data not found'
      ]);
    }
    

    $i=count($field_id);

    for($j=0 ; $j<$i ; $j++){
      $field=field::find($field_id[$j]->id);  
      $pond_id = DB::table('ponds')->where('field_id','=',$field_id[$j]->id)->get(); 
      $i2=count($pond_id);
      for($j2=0 ; $j2<$i2 ; $j2++){
       $pond=pond::find($pond_id[$j2]->id);
       $result1[$j2]=array(
         'pond_name'=> $pond->pond_name,
         'pond_id'=> $pond->id,
         'is_closed'=> $pond->is_closed
       );
     } ;
     $result[$j]=array(
       'field_name'=> $field->field_name,
       'field_id'=> $field->id,
       'pond'=>$result1);
     if($j!=$i-1){
     $result1=null;
   }
     };

    // $work = DB::table('fields')
    // ->where('workspace_id', '=', $workspace_id)
    // ->select('id','field_name')
    // ->get();

    // $work = DB::table('fields')
    // ->where('fields.workspace_id', '=', $workspace_id)
    // ->join('ponds', 'ponds.field_id', '=', 'fields.id')
    // ->select('ponds.field_id','fields.field_name','ponds.id','ponds.pond_name')
    // ->get(); 

     return response()->json([
      'result' => $result,
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
}