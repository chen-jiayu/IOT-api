<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
			$district_num=$data[$j]["district"];
			$district_name=$data[$j]["d-id"];
			
			$district=new district();
			$district->id=$district_num;
			if(!empty(district::find($district_num))){
				return response()->json([
					'status' => '0',
					'code'=>3,
					'message'=>'data duplicate'
				]);
			}
			$district->district_name=$district_name;
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
			DB::connection()->getPdo()->beginTransaction();
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
			if(empty($districts)){
				return response()->json([
					'status' => '0',
					'code'=>2,
					'message'=>'data not found'
				]);
			}
			DB::connection()->getPdo()->commit();
			return response()->json([
				'result'=>$districts,
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
