<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\state;
use App\district;
use App\rainfall;
use DB;

class rainfallController extends Controller
{
  public function store(Request $request) 
  {
    try{
     DB::connection()->getPdo()->beginTransaction();
     $city=DB::table('states')->where('state_name', '=',$request->input('city'))->value('id');
     $town=DB::table('districts')->where('district_name', '=',$request->input('district'))->value('id');

     if(empty($city)&&empty($town)){
      return response()->json([
        'status' => '0',
        'code'=>2,
        'message'=>'data not found'
      ]);
    }
    $rainfall=new rainfall();
    $rainfall->station_id=$request->input('station_id');
    $rainfall->locationName=$request->input('locationName');
    $rainfall->CITY=$city;
    $rainfall->TOWN=$town;
    $rainfall->time=$request->input('TIME');
    $rainfall->day=$request->input('DAY');
    $rainfall->ELEV=$request->input('ELEV');
    $rainfall->RAIN=$request->input('RAIN');
    $rainfall->MIN_10=$request->input('MIN_10');
    $rainfall->HOUR_3=$request->input('HOUR_3');
    $rainfall->HOUR_6=$request->input('HOUR_6');
    $rainfall->HOUR_12=$request->input('HOUR_12');
    $rainfall->HOUR_24=$request->input('HOUR_24');
    $rainfall->NOW=$request->input('NOW');
    $rainfall->ATTRIBUTE=$request->input('ATTRIBUTE');
    $rainfall->save();
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

public function get(Request $request,$state_id,$district_id,$time) 
{
  try{
    DB::connection()->getPdo()->beginTransaction();
    $rainfall=DB::table('rainfalls')->where('CITY', '=',$state_id)->where('TOWN', '=',$district_id)->where('DAY', '=',$time)->get();
    if(empty($rainfall)){
      return response()->json([
        'status' => '0',
        'code'=>2,
        'message'=>'data not found'
      ]);
    }
    return response()->json([
      'result' => $rainfall,	
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

}
