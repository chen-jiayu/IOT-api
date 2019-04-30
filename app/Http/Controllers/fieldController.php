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
      if(!empty($id)){
        if(DB::table('fields')->where('field_name', '=',$request->input('field_name'))==true){
          return response()->json([
            'status' => '0',
            'code'=>3,
            'message'=>'data duplicate'
          ]);
        }
        $workspace_id=DB::table('users')->where('id', '=',$id )->value('workspace_id');
        if(empty($workspace_id)){
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

        return response()->json([
          'result'=> $field->id,
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

  public function put(Request $request,$field_id) 
  {
    try {
      DB::connection()->getPdo()->beginTransaction();
      $id=$request->get('remeber_token');
      if(!empty($id)){
        $workspace_id=DB::table('users')->where('id', '=',$id )->value('workspace_id');
        $field = field::find($field);
        if(empty($field_feed_log)){
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

       return response()->json([
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

public function get(Request $request,$field_id) 
{
  try {
    DB::connection()->getPdo()->beginTransaction();
    $id=$request->get('remeber_token');
    if(!empty($id)){
      $workspace_id=DB::table('users')->where('id', '=',$id )->value('workspace_id');
      $field = field::find($field_id);
      if(empty($field)){
        return response()->json([
          'status' => '0',
          'code'=>2,
          'message'=>'data not found'
        ]);
      }  
      $state_name=DB::table('states')->where('id', '=',$field->state_id )->value('state_name');
      if($field->workspace_id==$workspace_id){
        $pond=DB::table('ponds')->where('field_id', '=',$field_id )->select('id','pond_name')->get();
        $result=array(
         'state_name'=> $state_name,
         'workspace_id'=> $field->workspace_id,
         'fieid_name'=>  $field->field_name,
         'pond'=>$pond
       );
        return response()->json([
          'result'=>$result,
          'status' => '1'
        ]);}
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
