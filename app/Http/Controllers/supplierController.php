<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\supplier;
use App\user;
use DB;

class supplierController extends Controller
{
  public function __construct()
  {
    $this->middleware('returnid');
  }
  public function store(Request $request) 
  {   
    try{
      DB::connection()->getPdo()->beginTransaction();
      $id=$request->get('remeber_token');
      
       $workspace_id=DB::table('users')->where('id', '=',$id )->value('workspace_id');
       if(count($workspace_id)!=0){
        return response()->json([
          'status' => '0',
          'code'=>2,
          'message'=>'data not found'
        ]);
      }
      $supplier=new supplier();
      $supplier->workspace_id=$workspace_id;
      $supplier->supplier_type=$request->input('supplier_type');
      $supplier->supplier_name=$request->input('supplier_name');
      $supplier->contact_name_1=$request->input('contact_name_1');
      $supplier->contact_phone_1=$request->input('contact_phone_1');
      $supplier->contact_name_2=$request->input('contact_name_2');
      $supplier->contact_phone_2=$request->input('contact_phone_2');
      $supplier->address=$request->input('address');
      $supplier->note=$request->input('note');
      $supplier->save();
      DB::connection()->getPdo()->commit();
      return response()->json([
        'result'=>$supplier->id,
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
 //取得廠商列表
public function gets(Request $request) 
{
  try{
   
    $id=$request->get('remeber_token');
    $workspace_id=DB::table('users')->where('id', '=',$id )->value('workspace_id');
    $type=$request->input('supplier_type');

      $supplier=DB::table('suppliers')->where('workspace_id', '=',$workspace_id)->where('supplier_type', '=',$type)->select('id','workspace_id', 'supplier_type','supplier_name','contact_name_1','contact_phone_1','contact_name_2','contact_phone_2','address','note' )->get();

      if(count($supplier)==0){
        return response()->json([
          'status' => '0',
          'code'=>2,
          'message'=>'data not found'
        ]);
      }
      
      return response()->json([
        'result' => $supplier,
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

public function get(Request $request,$supplier_id) 
{
  try{
    
    $id=$request->get('remeber_token');
    
    $supplier = supplier::find($supplier_id);
      if(count($supplier)==0){
        return response()->json([
          'status' => '0',
          'code'=>2,
          'message'=>'data not found'
        ]);
      }
      $result=array(
        'workspace_id'=>$supplier->workspace_id,
        'supplier_name'=> $supplier->supplier_name,
        'supplier_type'=>$supplier->supplier_type,
        'contact_name_1'=>$supplier->contact_name_1,
        'contact_phone_1'=> $supplier->contact_phone_1,
        'contact_name_2'=>$supplier->contact_name_2,
        'contact_phone_2'=> $supplier->contact_phone_2,
        'address'=>$supplier->address,
        'note'=>$supplier->note
      );
      
      return response()->json([
        'result' => $result,
        'status' => '1'
      ]);
      
   }catch (\PDOException $e) {
    
    return response()->json([
      'status' => '0',
      'code'=>0,
      'message'=>$e->getMessage()

    ]);
  }
}

    //場商修改
public function put(Request $request,$supplier_id) 
{
  try{
    DB::connection()->getPdo()->beginTransaction();
    $id=$request->get('remeber_token');
    
     $supplier = supplier::find($supplier_id);
     if(count($supplier)==0){
      return response()->json([
        'status' => '0',
        'code'=>2,
        'message'=>'data not found'
      ]);
    }
    $supplier->supplier_name=$request->input('supplier_name');
    $supplier->contact_name_1=$request->input('contact_name_1');
    $supplier->contact_phone_1=$request->input('contact_phone_1');
    $supplier->contact_name_2=$request->input('contact_name_2');
    $supplier->contact_phone_2=$request->input('contact_phone_2');
    $supplier->address=$request->input('address');
    $supplier->note=$request->input('note');
    $supplier->save();

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
}
