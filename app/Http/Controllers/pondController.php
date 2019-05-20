<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\user;
use App\pond;
use App\pond_shrimp;
use App\field;
use DB;

class pondController extends Controller
{
  public function __construct()
  {
    $this->middleware('returnid');

  }
  public function store(Request $request) 
  { 
    try{
      $id=$request->get('remeber_token');
      if(!empty($id)){
        if(DB::table('ponds')->where('pond_name', '=',$request->input('pond_name'))==true){
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
        DB::connection()->getPdo()->beginTransaction();
        $state_id=DB::table('fields')->where('id', '=',$request->input('field_id') )->value('state_id');
        $pond=new pond();
        $pond->workspace_id=$workspace_id;
        $pond->field_id=$request->input('field_id');
        $pond->pond_name=$request->input('pond_name');
        $pond->long=$request->input('long');
        $pond->depth=$request->input('depth');
        $pond->width=$request->input('width');
        $pond->waterwheel=$request->input('waterwheel');
        $pond->save();

        DB::connection()->getPdo()->commit();
        return response()->json([
          'result'=>$pond->id,
          'status' => '1'
        ]);
      }
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

  public function put(Request $request,$pond_id) 
  { 
    try{
      $id=$request->get('remeber_token');
      if(!empty($id)){
        $workspace_id=DB::table('users')->where('id', '=',$id )->value('workspace_id');
        $pond = pond::find($pond_id);
        if(empty($pond)){
          return response()->json([
            'status' => '0',
            'code'=>2,
            'message'=>'data not found'
          ]);
        }
        DB::connection()->getPdo()->beginTransaction();
        if($pond->workspace_id==$workspace_id){
          $pond->pond_name=$request->input('pond_name');
          $pond->is_closed=$request->input('is_closed');
          $pond->long=$request->input('long');
          $pond->depth=$request->input('depth');
          $pond->width=$request->input('width');
          $pond->waterwheel=$request->input('waterwheel');
          $pond->save();
          if($request->input('is_closed')==1){
           $pond_shrimp_id=DB::table('pond_shrimps')->where('pond_id', '=',$pond_id )->where('is_closed', '=',0 )->value('id');
           if(!empty($pond_shrimp_id)){
             $pond_shrimp = pond_shrimp::find($pond_shrimp_id);          
             $pond_shrimp->is_closed='1';
             $pond_shrimp->save();
           }
         }
         DB::connection()->getPdo()->commit();
         return response()->json([
          'status' => '1'
        ]);

       }
     }
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

public function get(Request $request,$pond_id) 
{
  try{
    DB::connection()->getPdo()->beginTransaction();
    $id=$request->get('remeber_token');
    if(!empty($id)){
      $workspace_id=DB::table('users')->where('id', '=',$id )->value('workspace_id');
      $pond = pond::find($pond_id);
      if(empty($pond)){
        return response()->json([
          'status' => '0',
          'code'=>2,
          'message'=>'data not found'
        ]);
      }
    	   if($pond->workspace_id==$workspace_id){//isclose=0 最新
          $pond_shrimp_id=DB::table('pond_shrimps')->where('pond_id', '=',$pond_id )->where('is_closed', '=',0 )->value('id');
          $pond_shrimp = pond_shrimp::find($pond_shrimp_id);
          $result = array(
            'id' =>  $pond->id,
            'field_id' =>  $pond->field_id,
            'pond_name' =>  $pond->pond_name,
            'long' => $pond->long,            
            'depth' => $pond->depth,
            'width' => $pond->width,
            'waterwheel' => $pond->waterwheel,
            'is_closed' => $pond->is_closed,
            'pond_shrimp'=>array(
             'id' =>  $pond_shrimp->id,
             'babysprimp' => $pond_shrimp->babysprimp,
             'shrimp_type' => $pond_shrimp->shrimp_type,
             'number' => $pond_shrimp->number,
             'density' => $pond_shrimp->density,
             'start_date' => $pond_shrimp->start_date,
             'end_date' =>$pond_shrimp->end_date
           )
          ); 
          DB::connection()->getPdo()->commit();
          return response()->json([
            'result'=>$result,
            'status' => '1'
          ]);
        }
      }
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
