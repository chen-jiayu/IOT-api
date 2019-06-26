<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\user;
use App\pond;
use App\pond_shrimp;
use App\field;
use DB;

class pondshrimpController extends Controller
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
       $workspace_id=DB::table('users')->where('id', '=',$id )->value('workspace_id');
      // $state_id=DB::table('fields')->where('id', '=',$request->input('field_id') )->value('state_id');
       DB::connection()->getPdo()->beginTransaction();
       DB::table('pond_shrimps')
       ->where('workspace_id', '=',$workspace_id)
       ->where('pond_id', '=',$request->input('pond_id'))->update(['is_closed'=>'1']);

       $pond_shrimp=new pond_shrimp();
       $pond_shrimp->workspace_id=$workspace_id;
       $pond_shrimp->field_id=$request->input('field_id');
       $pond_shrimp->pond_id=$request->input('pond_id');
       $pond_shrimp->supplier_id=$request->input('supplier_id');
       $pond_shrimp->babysprimp=$request->input('babysprimp');
       $pond_shrimp->density=$request->input('density');
       $pond_shrimp->note=$request->input('note');
       $pond_shrimp->shrimp_type=$request->input('shrimp_type');
       $pond_shrimp->number=$request->input('number');
       $pond_shrimp->start_date=$request->input('start_date');
       $pond_shrimp->end_date=$request->input('end_date');
       $pond_shrimp->save();

       DB::connection()->getPdo()->commit();
       return response()->json([
        'result'=>$pond_shrimp->id,
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
      $pondshrimp_id=DB::table('pond_shrimps')->where('pond_id','=',$pond_id)->where('is_closed','=',0 )->value('id');	
      $pondshrimp = pond_shrimp::find($pondshrimp_id);
      $pondshrimp->babysprimp=$request->input('babysprimp');
      $pondshrimp->density=$request->input('density');
      $pondshrimp->shrimp_type=$request->input('shrimp_type');
      $pondshrimp->note=$request->input('note');
      $pondshrimp->number=$request->input('number');
      $pondshrimp->start_date=$request->input('start_date');
      $pondshrimp->end_date=$request->input('end_date');
      $pondshrimp->save();
      
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
}
