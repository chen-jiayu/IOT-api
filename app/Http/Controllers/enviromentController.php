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

  public function store(Request $request) 
  {

    function unicodeDecode($unicode_str){
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
        DB::table('enviroments')->where('district_id', '=',$twon_id)->where('DAY', '=',$data[$j]["DAY"])->where('TIME', '=',$data[$j]["TIME"])->delete();

        if(empty($city_id)||empty($twon_id)){
        return response()->json([
          'status' => '0',
          'code'=>2,
          'message'=>'data not found'
        ]);
      }

        $enviroment=new enviroment();
        $enviroment->state=$data[$j]["city"];
        $enviroment->district=$data[$j]["district"];
        $enviroment->state_id=$city_id;
        $enviroment->district_id=$twon_id;
        $enviroment->TEMP=$data[$j]["TEMP"];
        $enviroment->WIND=$data[$j]["WIND"];
        $enviroment->WS=$data[$j]["WS"];
        $enviroment->BF=$data[$j]["BF"];
        $enviroment->DAY=$data[$j]["DAY"];
        $enviroment->TIME=$data[$j]["TIME"];
        $enviroment->Wx=$data[$j]["Wx"];
        $enviroment->PoP6h=$data[$j]["PoP6h"];
        $enviroment->PoP12h=$data[$j]["PoP12h"];
        $enviroment->get_day=$data[$j]["get_day"];
        $enviroment->save();

      }
      DB::connection()->getPdo()->commit();
      return response()->json([
        'status' => '1'

      ]);
      
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
    
    $today=$c;
    $ThisDay = strtotime($today."+6 day");
    $CheckDay= date("Y-m-d",$ThisDay); 

    $enviroment=DB::table('enviroments')->where('state_id', '=',$a)->where('district_id', '=',$b) ->whereBetween('day', [$today, $CheckDay])->select('state_id','state','district_id','district','DAY','TIME','TEMP','WIND','WS','BF','Wx','PoP6h','PoP12h','get_day')->get();


    DB::connection()->getPdo()->commit();
    return response()->json([
      'result'=>$enviroment,
      'status' => '1'

    ]);
  }
}
