<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\enviroment;
use App\state;
use App\district;
use DB;

class enviromentController extends Controller
{
    //
  public function __construct()
  {
    $this->middleware('returnid');
    
  }
  public function store(Request $request) 
  {
    try{
      DB::connection()->getPdo()->beginTransaction();
      $id=$request->get('remeber_token');
      DB::connection()->getPdo()->beginTransaction();
      $city=DB::table('states')->where('state_name', '=',$request->input('city'))->value('id');
      $twon=DB::table('districts')->where('district_name', '=',$request->input('district'))->value('id');
      DB::table('enviroments')->where('day', '=',$request->input('DAY'))->where('time', '=',$request->input('TIME'))->delete();
      if(!empty($id)){
       $enviroment=new enviroment();
       $enviroment->state_id=$city;
       $enviroment->district_id=$twon;
       $enviroment->temperature=$request->input('TEMP');
       $enviroment->wind_direction=$request->input('WIND');
       $enviroment->wind_speed=$request->input('WS');
       $enviroment->wind_scale=$request->input('BF');
       $enviroment->day=$request->input('DAY');
       $enviroment->time=$request->input('TIME');
       $enviroment->weather=$request->input('Wx');
       $enviroment->PoP6h=$request->input('PoP6h');
       $enviroment->PoP12h=$request->input('PoP12h');
       $enviroment->get_day=$request->input('get_day');
       $enviroment->save();

       DB::connection()->getPdo()->commit();
       return response()->json([
        'status' => '1'

      ]);}
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
  public function get(Request $request,$a,$b,$c) 
  {
    DB::connection()->getPdo()->beginTransaction();
    $id=$request->get('remeber_token');
    if(!empty($id)){
      $today=$c;
      $ThisDay = strtotime($today."+6 day");
      $CheckDay= date("Y-m-d",$ThisDay); 

      $enviroment=DB::table('enviroments')->where('state_id', '=',$a)->where('district_id', '=',$b) ->whereBetween('day', [$today, $CheckDay])->select('state_id','district_id','day','time','temperature','atmospheric_pressure','wind_direction','wind_speed','wind_scale','wind_gust','air_quality','relative_humidity','weather','PoP6h','PoP12h','get_day','is_deleted')->get();


    }
    DB::connection()->getPdo()->commit();
    return response()->json([
      'result'=>$enviroment,
      'status' => '1'

    ]);
  }
}
