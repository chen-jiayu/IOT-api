<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\workspace_user;
use App\workspace;
use App\user;
use DB;
use Illuminate\Support\Arr;


class workspacesController extends Controller
{   
    public function __construct()
    {
        // 所有 method 都會先經過 auth 這個 middleware
        $this->middleware('returnid');
 
        // 只有 create 會經過 auth 這個 middleware
      //  $this->middleware('auth',['only' => 'create']);
 
        // 除了 index 之外都會先經過 auth 這個 middleware
        //$this->middleware('returnid',['except' => 'checktoken','store']);
    }
    //修改正在使用蝦場
    public function show(Request $request)  
    {   $workspace=$request->header('workspace_id');
        $id=$request->get('remeber_token');
       // $id = DB::table('workspace_users')->where('workspace_id', $workspace )->value('user_id');
        $user = user::find($id);
        $user->workspace_id=$workspace;
        $user->save();          
        return response()->json([
            'status' => '1'
]);                       
    }

    public function store(Request $request)  //建立養殖場，workspace_user新增
    {
        $this->validate($request,[
            'workspace_name'=>'required',
            'invite_code'=>'required'
     ]); 
        $id=$request->get('remeber_token');
        
    $name = DB::table('workspaces')->where('invite_code','=',$request->input('invite_code') )->value('invite_code');
      //$name =DB::table('workspaces')->select('invite_code')->get();

            if(!empty($name)){
            return response()->json([
            'error'=>'invite code exist',
            'status' => '0'
]); 
            }
          else 

            if(!empty($id)){
         $workspace = new workspace();
         $workspace->workspace_name= $request->input('workspace_name');
         $workspace->invite_code= $request->input('invite_code');
         $workspace->save();
     
         $workspace_user = new workspace_user();
         $workspace_user->user_id=$id;
         $workspace_user->workspace_id=$workspace->id;
         $workspace_user->save();
          return response()->json([
            //'l'=>$name,
            'status' => '1'
]); }
      
  }
      
}