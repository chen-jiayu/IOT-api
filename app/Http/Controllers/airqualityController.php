<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\state;
use App\district;
use App\airquality;
use DB;

class airqualityController extends Controller
{
	public function store(Request $request) 
	{
		try{
			DB::connection()->getPdo()->beginTransaction();
			$city=DB::table('states')->where('state_name', '=',$request->input('city'))->value('id');
			$twon = DB::table('districts')->where(\DB::raw('SUBSTRING(district_name, 1, 2)'),'=',$request->input('district'))->value('id');

			if(empty($city)||empty($twon)){
				return response()->json([
					'status' => '0',
					'code'=>2,
					'message'=>'data not found'
				]);
			}
			$airquality=new airquality();
			$airquality->AQI=$request->input('AQI');
			$airquality->CO=$request->input('CO');
			$airquality->CITY=$city;
			$airquality->TOWN=$twon;
			$airquality->CO_8hr=$request->input('CO_8hr');
			$airquality->Latitude=$request->input('Latitude');
			$airquality->Longitude=$request->input('Longitude');
			$airquality->NO=$request->input('NO');
			$airquality->NO2=$request->input('NO2');
			$airquality->NOx=$request->input('NOx');
			$airquality->O3=$request->input('O3');
			$airquality->O3_8hr=$request->input('O3_8hr');
			$airquality->PM10=$request->input('PM10');
			$airquality->PM10_AVG=$request->input('PM10_AVG');
			$airquality->PM2_5=$request->input('PM2.5');
			$airquality->PM2_5_AVG=$request->input('PM2.5_AVG');
			$airquality->Pollutant=$request->input('Pollutant');
			$airquality->time=$request->input('TIME');
			$airquality->day=$request->input('DAY');
			$airquality->status=$request->input('status');
			$airquality->SO2=$request->input('SO2');
			$airquality->SO2_AVG=$request->input('SO2_AVG');
			$airquality->save();
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
