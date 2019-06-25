<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\user;
use App\field_feed;
use App\field;
use App\supplier;
use DB;

class field_feedController extends Controller
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
    if(count($workspace_id)==0){
      return response()->json([
        'status' => '0',
        'code'=>2,
        'message'=>'data not found'
      ]);
    }
    $field_feed=new field_feed();
    $field_feed->workspace_id=$workspace_id;
    $field_feed->field_id=$request->input('field_id');
    $field_feed->supplier_id=$request->input('supplier_id');
    $field_feed->feed_size=$request->input('feed_size');
    $field_feed->inventory_weight=$request->input('inventory_weight');
    $field_feed->inventory_min=$request->input('inventory_min');
    $field_feed->save();

    DB::connection()->getPdo()->commit();
    return response()->json([
      'result'=> $field_feed->id,
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
public function put(Request $request,$field_feed_id) 
{
  try {
    DB::connection()->getPdo()->beginTransaction();
    $id=$request->get('remeber_token');
    
    $field_feed = field_feed::find($field_feed_id);
    if(count($field_feed)==0){
      return response()->json([
        'status' => '0',
        'code'=>2,
        'message'=>'data not found'
      ]);
    }
    $field_feed->supplier_id=$request->input('supplier_id');
    $field_feed->feed_size=$request->input('feed_size');
    $field_feed->inventory_weight=$request->input('inventory_weight');
    $field_feed->inventory_min=$request->input('inventory_min');
    $field_feed->save();
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
public function get(Request $request,$field_feed_id) 
{
  try {
    
    $id=$request->get('remeber_token');
    
    $field_feed = field_feed::find($field_feed_id);
    if(count($field_feed)==0){
      return response()->json([
        'status' => '0',
        'code'=>2,
        'message'=>'data not found'
      ]);
    }
    $result=array('workspace_id'=>$field_feed->workspace_id,
     'field_id'=>$field_feed->field_id,
     'supplier_id'=>$field_feed->supplier_id,
     'feed_size'=>$field_feed->feed_size,
     'inventory_weight'=>$field_feed->inventory_weight,
     'inventory_min'=>$field_feed->inventory_min,
     'is_deleted'=>$field_feed->is_deleted
   );
    
    return response()->json([
      'result'=>$result,
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
