<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\sensor_group;
use App\user;
use DB;

class sensor_groupController extends Controller
{
    //
	public function __construct()
	{
		$this->middleware('returnid');
	}
	public function store(Request $request) 
	{
		try {
			DB::connection()->getPdo()->beginTransaction();
			$id=$request->get('remeber_token');
			$workspace_id=DB::table('users')->where('id', '=',$id )->value('workspace_id');
			$name=DB::table('sensor_groups')->where('sensor_name', '=',$request->input('sensor_name') )->get();
			if(count($workspace_id)==0){
				return response()->json([
					'status' => '0',
					'code'=>2,
					'message'=>'data not found'
				]);
			}
			if(count($name)!=0){
				return response()->json([
					'status' => '0',
					'code'=>3,
					'message'=>'data duplicate'
				]);
			}
			$sensor_group=new sensor_group();
			$sensor_group->workspace_id=$workspace_id;
			$sensor_group->field_id=$request->input('field_id');
			$sensor_group->pond_id=$request->input('pond_id');
			$sensor_group->sensor_name=$request->input('sensor_name');
			$sensor_group->status=$request->input('status');
			$sensor_group->is_open=$request->input('is_open');
			$sensor_group->created_id=$id;
			$sensor_group->updated_id=$id;
			$sensor_group->save();
			DB::connection()->getPdo()->commit();
			return response()->json([
				'result'=> $sensor_group->id,
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
	public function get(Request $request,$sensor_group_id) 
	{
		try{
			$id=$request->get('remeber_token');
			$workspace_id=DB::table('users')->where('id', '=',$id )->value('workspace_id');
			$sensor_group=DB::table('sensor_groups')->where('workspace_id', '=',$workspace_id)->where('sensor_group_id', '=',$sensor_group_id)->select('sensor_group_id', 'workspace_id','field_id','pond_id','sensor_name','status','is_open','is_deleted','created_id','updated_id')->get();
			if(count($sensor_group)==0){
				return response()->json([
					'status' => '0',
					'code'=>2,
					'message'=>'data not found'
				]);
			}

			return response()->json([
				'result' => $sensor_group,	
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
	public function gets(Request $request,$sensor_group_id) 
	{
		try{
			$id=$request->get('remeber_token');
			$workspace_id=DB::table('users')->where('id', '=',$id )->value('workspace_id');
			$sensor_group=DB::table('sensor_groups')->where('workspace_id', '=',$workspace_id)->where('pond_id', '=',$pond_id)->select('sensor_group_id', 'workspace_id','field_id','pond_id','sensor_name','status','is_open','is_deleted','created_id','updated_id')->get();
			if(count($sensor_group)==0){
				return response()->json([
					'status' => '0',
					'code'=>2,
					'message'=>'data not found'
				]);
			}

			return response()->json([
				'result' => $sensor_group,	
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
	public function put(Request $request,$sensor_group_id) 
	{
		try{
			$id=$request->get('remeber_token');
            $sensor_group=DB::table('sensor_groups')->where('sensor_group_id', '=',$sensor_group_id)->update(['sensor_name' => $request->input('sensor_name'),'is_open' => $request->input('is_open')]);
			
			DB::connection()->getPdo()->beginTransaction();

			if(count($sensor_group)==0){
				return response()->json([
					'status' => '0',
					'code'=>2,
					'message'=>'data not found'
				]);
			} 
			
			DB::connection()->getPdo()->commit();
			return response()->json([
				'status' => $sensor_group
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
