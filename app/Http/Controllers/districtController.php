<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\district;
use DB;

class districtController extends Controller
{
	public function store(Request $request) 
	{
		try {
			DB::connection()->getPdo()->beginTransaction();
			$district=new district();
			$district->id=$request->input('id');
			if(!empty(district::find($request->input('id')))){
               return response()->json([
				'status' => '0',
				'code'=>3,
				'message'=>'data duplicate'
			]);
			}
			$district->district_name=$request->input('district_name');
			$district->save();
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
			DB::connection()->getPdo()->beginTransaction();
			$districts=DB::table('districts')->select('id','district_name')->get();
			if(empty($districts)){
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
			DB::connection()->getPdo()->rollBack();
			return response()->json([
				'status' => '0',
				'code'=>0,
				'message'=>$e->getMessage()
			]);
		}
	}
}
