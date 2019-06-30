<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
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
      $count=DB::table('ponds')->where('pond_name', '=',$request->input('pond_name'))->where('field_id', '=',$request->input('field_id'))->get();
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
      $pond->is_closed=$request->input('is_closed');
      $pond->save();

      DB::connection()->getPdo()->commit();
      return response()->json([
        'result'=>$pond->id,
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

  public function put(Request $request,$pond_id) 
  { 
    try{
      $id=$request->get('remeber_token');
      
      $workspace_id=DB::table('users')->where('id', '=',$id )->value('workspace_id');
      $pond = pond::find($pond_id);
      if(count($pond)==0){
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

    $id=$request->get('remeber_token');

      $workspace_id=DB::table('users')->where('id', '=',$id )->value('workspace_id');
      $pond = pond::find($pond_id);
      if(count($pond)==0){
        return response()->json([
          'status' => '0',
          'code'=>2,
          'message'=>'data not found'
        ]);
      }
    	   if($pond->workspace_id==$workspace_id){//isclose=0 最新
          $pond_shrimp = DB::table('pond_shrimps')->where('pond_id', '=',$pond_id )->where('is_closed', '=',0 )->select('id','supplier_id','babysprimp','shrimp_type','number','density','start_date','end_date')->get();
          
          $result = array(
            'pond_id' =>  $pond->id,
            'field_id' =>  $pond->field_id,
            'pond_name' =>  $pond->pond_name,
            'long' => $pond->long,            
            'depth' => $pond->depth,
            'width' => $pond->width,
            'waterwheel' => $pond->waterwheel,
            'is_closed' => $pond->is_closed,
            'pond_shrimp'=>$pond_shrimp
          ); 
          
          return response()->json([
            'result'=>$result,
            'status' => '1'
          ]);
        }
      
    } catch (\PDOException $e) {
     
      return response()->json([
        'status' => '0',
        'code'=>0,
        'message'=>$e->getMessage()
      ]);
    }
  } 
}
