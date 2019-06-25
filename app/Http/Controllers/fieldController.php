<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\user;
use App\field;
use App\pond;
use App\state;
use DB;

class fieldController extends Controller
{
    //
  public function __construct()
  {
    $this->middleware('returnid');

  }
  public function store(Request $request) 
  {
    try {
      DB::connection()->getPdo()->beginTransaction();
      $id=$request->get('remeber_token');
      $workspace_id=DB::table('users')->where('id', '=',$id )->value('workspace_id');
      $count=DB::table('fields')->where('workspace_id', '=',$workspace_id)->where('field_name', '=',$request->input('field_name'))->get();
      if(count($count)!=0){
        return response()->json([
          'status' => '0',
          'code'=>3,
          'message'=>'data duplicate'
        ]);
      }
      $workspace_id=DB::table('users')->where('id', '=',$id )->value('workspace_id');
      if(count($workspace_id)==0){
        return response()->json([
          'status' => '0',
          'code'=>2,
          'message'=>'data not found'
        ]);
      }
      $field=new field();
      $field->workspace_id=$workspace_id;
      $field->field_name=$request->input('field_name');
      $field->state_id=$request->input('state_id');
      $field->save();
      DB::connection()->getPdo()->commit();
      return response()->json([
        'result'=> $field->id,
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

  public function put(Request $request,$field_id) 
  {
    try {
      DB::connection()->getPdo()->beginTransaction();
      $id=$request->get('remeber_token');
      $workspace_id=DB::table('users')->where('id', '=',$id )->value('workspace_id');
      $field = field::find($field_id);
      if(count($field)==0){
        return response()->json([
          'status' => '0',
          'code'=>2,
          'message'=>'data not found'
        ]);
      }
      if($field->workspace_id==$workspace_id){
       $field->field_name=$request->input('field_name');
       $field->state_id=$request->input('state_id');
       $field->save();
     }
     DB::connection()->getPdo()->commit();
     return response()->json([
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

public function get(Request $request,$field_id) 
{
  try {

    $id=$request->get('remeber_token');
    $workspace_id=DB::table('users')->where('id', '=',$id )->value('workspace_id');
    $field = field::find($field_id);
    if(count($field)==0){
      return response()->json([
        'status' => '0',
        'code'=>2,
        'message'=>'data not found'
      ]);
    }  
    $state_name=DB::table('states')->where('id', '=',$field->state_id )->value('state_name');
    if($field->workspace_id==$workspace_id){
      $pond=DB::table('ponds')->where('field_id', '=',$field_id )->select('id','pond_name')->get();
      $i=count($pond);
      for($j=0 ; $j<$i ; $j++){
      $result2[$j]=array(
         'pond_id'=> $pond[$j]->id,
         'pond_name'=> $pond[$j]->pond_name);
      };
      $result=array(
       'state_name'=> $state_name,
       'workspace_id'=> $field->workspace_id,
       'field_name'=>  $field->field_name,
       'is_closed'=>$field->is_closed,
       'pond'=>$result2
     );

      return response()->json([
        'result'=>$result,
        'status' => '1'
      ]);}
      
    } catch (\PDOException $e) {

      return response()->json([
        'status' => '0',
        'code'=>0,
        'message'=>$e->getMessage()
      ]);
    }
  }
}
