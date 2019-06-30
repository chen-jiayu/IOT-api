<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\user;
use App\field_feed;
use App\field;
use App\field_feed_log;
use App\daily_note;
use DB;

class field_feed_logController extends Controller
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
      $field_feed_log=new field_feed_log();
      $field_feed_log->workspace_id=$workspace_id;
      $field_feed_log->field_id=$request->input('field_id');
      $field_feed_log->source_type=$request->input('source_type');
      $field_feed_log->feed_id=$request->input('feed_id');
      
      if($request->input('source_type')==1){
        field_feed::find($request->input('feed_id'))->increment('inventory_weight',$request->input('inventory_weight'));
      }
      if($request->input('source_type')==2){
        $field_feed_log->daily_note_id=$request->input('daily_note_id');
        field_feed::find($request->input('feed_id'))->decrement('inventory_weight',$request->input('inventory_weight'));

      }
      $field_feed_log->inventory_weight=$request->input('inventory_weight');
      $field_feed_log->created_id=$id;

      $field_feed_log->save();
      DB::connection()->getPdo()->commit();
      return response()->json([
        'result'=> $field_feed_log->id,
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
  public function put(Request $request,$field_feed_log_id) 
  {
    try {
      DB::connection()->getPdo()->beginTransaction();
      $id=$request->get('remeber_token');
      $field_feed_log = field_feed_log::find($field_feed_log_id);
      if(count($field_feed_log)==0){
        return response()->json([
          'status' => '0',
          'code'=>2,
          'message'=>'data not found'
        ]);
      }

      field_feed_log::find($field_feed_log_id)->increment('inventory_weight',$request->input('inventory_weight'));
      if($field_feed_log->source_type==1){
        $feed_id=DB::table('field_feed_logs')->where('id', '=',$field_feed_log_id )->value('feed_id');
        field_feed::find($feed_id)->increment('inventory_weight',$request->input('inventory_weight'));
      }
      if($field_feed_log->source_type==2){
        $daily_id=DB::table('field_feed_logs')->where('id', '=',$field_feed_log_id )->value('daily_note_id');
        daily_note::find($daily_id)->increment('feeding_wieght',$request->input('inventory_weight'));
      }
      $field_feed_log->save();
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
  public function get(Request $request,$field_feed_log_id) 
  {
    try {

      $id=$request->get('remeber_token');

      $field_feed_log = field_feed_log::find($field_feed_log_id);
      if(count($field_feed_log)==0){
        return response()->json([
          'status' => '0',
          'code'=>2,
          'message'=>'data not found'
        ]);
      }
      $result=array(
       'workspace_id'=>$field_feed_log->workspace_id,
       'field_id'=>$field_feed_log->field_id,
       'source_type'=>$field_feed_log->source_type,
       'daily_note_id'=>$field_feed_log->daily_note_id,
       'feed_id'=>$field_feed_log->feed_id,
       'inventory_weight'=>$field_feed_log->inventory_weight

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
  public function gets(Request $request,$field_id) 
  {
    try {

      $id=$request->get('remeber_token');
      $result=DB::table('field_feed_logs')->where('field_id', '=',$field_id )->select('id','workspace_id','source_type','field_id','daily_note_id',
        'feed_id','inventory_weight')->get();
      if(count($result)==0){
        return response()->json([
          'status' => '0',
          'code'=>2,
          'message'=>'data not found'
        ]);
      }

      return response()->json([
        'result'=>$result,
        'status' => '1'

      ]);
      
    }catch (\PDOException $e) {

      return response()->json([
        'status' => '0',
        'code'=>0,
        'message'=>$e->getMessage()
      ]);
    }
  }
}
