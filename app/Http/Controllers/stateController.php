<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\state;
use DB;

class stateController extends Controller
{
    //
  public function store(Request $request) 
  {
   try {
    $data = $request->input('data');
    $i=count($data);
    DB::connection()->getPdo()->beginTransaction();

    for($j=0 ; $j<$i ; $j++){
      $state_num=$data[$j]["c-id"];
      $state_name=$data[$j]["city"];
     $state=new state();
     $state->id=$state_num;
     if(count(state::find($state_num))!=0){
      return response()->json([
        'status' => '0',
        'code'=>3,
        'message'=>'data duplicate'
      ]);
    }
    $state->state_name=$state_name;
    $state->save();
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

public function get(Request $request) 
{
  try {
    
   $states=DB::table('states')->select('id','state_name')->get();;
   if(count($states)==0){
     return response()->json([
      'status' => '0',
      'code'=>2,
      'message'=>'data not found'
    ]);
   }
   
   return response()->json([
    'result'=>$states,
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
