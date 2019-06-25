<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\user;
use App\field_feed;
use App\field;
use App\pond;
use App\daily_note;
use DB;

class daily_noteController extends Controller
{
    //
  public function __construct()
  {
    $this->middleware('returnid');

  }
  public function store(Request $request) 
  {
    try {
    	$id=$request->get('remeber_token');

      field_feed::find($request->input('feed_id'))->decrement('inventory_weight',$request->input('feeding_wieght'));


      if(count(DB::table('field_feeds')->where('id', '=',$id )->get())==0){
        return response()->json([
          'status' => '0',
          'code'=>2,
          'message'=>'data not found'
        ]);
      }

      DB::connection()->getPdo()->beginTransaction();
      $workspace_id=DB::table('users')->where('id', '=',$id )->value('workspace_id');
      $dailt_note=new daily_note();
      $dailt_note->workspace_id=$workspace_id;
      $dailt_note->field_id=$request->input('field_id');
      $dailt_note->pond_id=$request->input('pond_id');
      $dailt_note->feed_id=$request->input('feed_id');
      $dailt_note->note_date=$request->input('note_date');
      $dailt_note->feeding_wieght=$request->input('feeding_wieght');
      $dailt_note->eating_duration=$request->input('eating_duration');
      $dailt_note->feeding_time=$request->input('feeding_time');
      $dailt_note->note=$request->input('note');
      $dailt_note->created_id=$id;
      $dailt_note->updated_id=$id;
      $dailt_note->save();

      DB::connection()->getPdo()->commit();
      return response()->json([
        'result'=> $dailt_note->id,
        'status' => '1'

      ]);
      
    }catch (\PDOException $e) {
      DB::connection()->getPdo()->rollBack();
      return response()->json([
        'status' => '0',
        'code'=>0,
        'message'=>$e->getMessage()
      ]);
    }
  }

  public function put(Request $request,$note_id) 
  {
    try{
     $id=$request->get('remeber_token');
     $dailt_note = daily_note::find($note_id);
     if(count($dailt_note)==0){
      return response()->json([
        'status' => '0',
        'code'=>2,
        'message'=>'data not found'
      ]);
    }
    DB::connection()->getPdo()->beginTransaction();
    $dailt_note->note_date=$request->input('note_date');
    $dailt_note->feeding_wieght=$request->input('feeding_wieght');
    $dailt_note->eating_duration=$request->input('eating_duration');
    $dailt_note->note=$request->input('note');
    $dailt_note->updated_id=$id;
    $dailt_note->save();
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

public function get(Request $request,$note_id) 
{
 try{

   $id=$request->get('remeber_token');
   
   $daily_note = daily_note::find($note_id);
   if(count($daily_note)==0){
    return response()->json([
      'status' => '0',
      'code'=>2,
      'message'=>'data not found'
    ]);
  }
  $result=array('workspace_id'=>$daily_note->workspace_id,
   'field_id'=>$daily_note->field_id,
   'pond_id'=>$daily_note->pond_id,
   'feed_id'=>$daily_note->feed_id,
   'note_date'=>$daily_note->note_date,
   'feeding_wieght'=>$daily_note->feeding_wieght,
   'eating_duration'=>$daily_note->eating_duration,
   'note'=>$daily_note->note
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
public function gets(Request $request) 
{
 try{
   $id=$request->get('remeber_token');
   
   $result=DB::table('daily_notes')->where('pond_id', '=',$request->input('pond_id'))->get();
   // select('id','workspace_id','field_id','field_id','pond_id',
   //  'feed_id','note_date','feeding_wieght','eating_duration','note')
   if(empty($result)){
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


} catch (\PDOException $e) {

  return response()->json([
    'status' => '0',
    'code'=>0,
    'message'=>$e->getMessage()

  ]);
}
}

}
