<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\state;
use App\district;
use App\airquality;
use DB;

class airqualityController extends Controller
{
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
				
				$city=DB::table('states')->where('state_name', '=',unicodeDecode($data[$j]["city"]))->value('id');

				
			
				$twon = DB::table('districts')->where(\DB::raw('SUBSTRING(district_name, 1, 2)'),'=',unicodeDecode($data[$j]["district"]))->value('id');

				echo $twon;

				if(empty($twon)){
					continue;
				}

				$airquality=new airquality();
				$airquality->AQI=$data[$j]["AQI"];
				$airquality->CO=$data[$j]["CO"];
				$airquality->CITY=$city;
				$airquality->TOWN=$twon;
				$airquality->CO_8hr=$data[$j]["CO_8hr"];
				$airquality->Latitude=$data[$j]["Latitude"];
				$airquality->Longitude=$data[$j]["Longitude"];
				$airquality->NO=$data[$j]["NO"];
				$airquality->NO2=$data[$j]["NO2"];
				$airquality->NOx=$data[$j]["NOx"];
				$airquality->O3=$data[$j]["O3"];
				$airquality->O3_8hr=$data[$j]["O3_8hr"];
				$airquality->PM10=$data[$j]["PM10"];
				$airquality->PM10_AVG=$data[$j]["PM10_AVG"];
				$airquality->PM2_5=$data[$j]["PM2.5"];
				$airquality->PM2_5_AVG=$data[$j]["PM2.5_AVG"];
				$airquality->Pollutant=$data[$j]["Pollutant"];
				$airquality->day=$data[$j]["DAY"];
				$airquality->time=$data[$j]["TIME"];
				//$airquality->day=$data[$j]["get-day"];
				$airquality->status=$data[$j]["Status"];
				$airquality->SO2=$data[$j]["SO2"];
				$airquality->SO2_AVG=$data[$j]["SO2_AVG"];
				$airquality->save();
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
			$airquality=DB::table('airqualities')->where('CITY', '=',$state_id)->where('TOWN', '=',$district_id)->where('DAY', '=',$time)->get();
			if(empty($airquality)){
				return response()->json([
					'status' => '0',
					'code'=>2,
					'message'=>'data not found'
				]);
			}
			$airquality = airquality::latest()->first();
			DB::connection()->getPdo()->commit();
			return response()->json([
				'result' => $airquality,	
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
