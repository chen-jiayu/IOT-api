<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\workspace;
use App\user;
use App\option;
use App\pond_shrimp;
use App\field_feed;
use DB;

class optionController extends Controller
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
			if(!empty($id)){
				$option=new option();
				$option->workspace_id=$workspace_id;
				$option->opt_id=$request->input('opt_id');
				$option->opt_value=$request->input('opt_value');
				$option->save();

				DB::connection()->getPdo()->commit();
				return response()->json([
					'status' => '1'

				]);
			} else
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
	public function get(Request $request,$optid) 
	{
		try {
			
			$id=$request->get('remeber_token');

			$workspace_id=DB::table('users')->where('id', '=',$id )->value('workspace_id');
			if(count($workspace_id)==0){
				return response()->json([
					'status' => '0',
					'code'=>2,
					'message'=>'data not found'
				]);
			}
			if($optid=='shrimptype'){
				$option=DB::table('options')->where('opt_id', '=','shrimptype')->where('opt_id', '=','shrimptype')->get();
			}
			if($optid=='babysprimp'){
				$option=DB::table('options')->where('opt_id', '=','babysprimp')->where('opt_id', '=','babysprimp')->get();
			}
			if($optid=='feed_size'){
				$option=DB::table('options')->where('workspace_id', '=',$workspace_id)->where('opt_id', '=','feed_size')->get();
			}
			$result = array(
				'worksapce_id' =>  $workspace_id,
				'opt_id' =>  $optid,
				'opt_value' =>  $option
			); 

			return response()->json([
				'result'=>$option,
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
