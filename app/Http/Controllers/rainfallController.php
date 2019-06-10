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
    function unicodeDecode($unicode_str)
    {
    $json = '{"str":"'.$unicode_str.'"}';
    $arr = json_decode($json,true);
    if(empty($arr)) return '';
    return $arr['str'];
}
    try{
     $data = $request->input('data');
     $i=count($data);
     DB::connection()->getPdo()->beginTransaction();
     for($j=0 ; $j<$i ; $j++){
      $city_id=DB::table('states')->where('state_name', '=',unicodeDecode($data[$j]["city"]))->value('id');
      $twon_id= DB::table('districts')->where('district_name', '=',unicodeDecode($data[$j]["district"]))->value('id');
        DB::table('rainfalls')->where('TOWN', '=',$twon_id)->where('station_id', '=',$data[$j]["stationId"])->where('day', '=',$data[$j]["DAY"])->where('time', '=',$data[$j]["TIME"])->delete();
      if(empty($city_id)||empty($twon_id)){
        return response()->json([
          'status' => '0',
          'code'=>2,
          'message'=>'data not found'
        ]);
      }
      $rainfall=new rainfall();
      $rainfall->station_id=$data[$j]["stationId"];
      $rainfall->locationName=$data[$j]["locationName"];
      $rainfall->CITY=$city_id;
      $rainfall->TOWN=$twon_id;
      $rainfall->time=$data[$j]["TIME"];
      $rainfall->day=$data[$j]["DAY"];
      $rainfall->ELEV=$data[$j]["ELEV"];
      $rainfall->RAIN=$data[$j]["RAIN"];
      $rainfall->MIN_10=$data[$j]["MIN_10"];
      $rainfall->HOUR_3=$data[$j]["HOUR_3"];
      $rainfall->HOUR_6=$data[$j]["HOUR_6"];
      $rainfall->HOUR_12=$data[$j]["HOUR_12"];
      $rainfall->HOUR_24=$data[$j]["HOUR_24"];
      $rainfall->NOW=$data[$j]["NOW"];
      $rainfall->ATTRIBUTE=$data[$j]["ATTRIBUTE"];
      $rainfall->save();
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
    DB::connection()->getPdo()->commit();
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
