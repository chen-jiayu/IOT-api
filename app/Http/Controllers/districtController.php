<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\district;
use App\state;
use DB;

class districtController extends Controller
{
	public function store(Request $request) 
	{
		try {
			
			$data = $request->input('data');
			$i=count($data);
            DB::connection()->getPdo()->beginTransaction();
			for($j=0 ; $j<$i ; $j++){
			// $district_num=$data[$j]["district"];
			$city=$data[$j]["c-id"];
			
			$district=new district();
			$district->id=$data[$j]["district"];
			if(count(district::find($district_num))!=0){
				return response()->json([
					'status' => '0',
					'code'=>3,
					'message'=>'data duplicate'
				]);
			}
			if(Str::startsWith($city, 0)){
               $city=substr($city,1);
			}
			$district->state_id=$city;
			$district->district_name=$data[$j]["d-id"];
			$district->save();
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
	public function get(Request $request,$state_id) 
	{
		try {
			
			$x = strlen($state_id);
			if($x==3){
				$districts = DB::table('districts')->where(\DB::raw('SUBSTRING(id, 1, 3)'),'=',$state_id)->select('id','district_name')->get();
			}
			if($x==4){
				$districts = DB::table('districts')->where(\DB::raw('SUBSTRING(id, 1, 4)'),'=',$state_id)->select('id','district_name')->get();
			}
			if($x==5){
				$districts = DB::table('districts')->where(\DB::raw('SUBSTRING(id, 1, 5)'),'=',$state_id)->select('id','district_name')->get();
			}			
		//$districts=DB::table('districts')->select('id','district_name')->get();
			if(count($districts)==0){
				return response()->json([
					'status' => '0',
					'code'=>2,
					'message'=>'data not found'
				]);
			}
			
			return response()->json([
				'result'=>$districts,
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
