<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\user;
use App\workspace_user;
use DB;
use Hash;
use Illuminate\Http\RedirectResponseRedirectResponseredirect;

class loginController extends Controller
{
	 public function __construct()
    {
        // 所有 method 都會先經過 auth 這個 middleware
        //$this->middleware('returnid');
 
        // 只有 create 會經過 auth 這個 middleware
      //  $this->middleware('auth',['only' => 'create']);
 
        // 除了 index 之外都會先經過 auth 這個 middleware
        $this->middleware('returnid',['except' => 'checktoken','store']);
    }
    //登入
	public function checktoken(Request $request) {
    $credentials = request(['citizen_id', 'password']);

    $id= DB::table('users')->where('citizen_id', '=',$request->input('citizen_id') )->value('id');
    $id_token= DB::table('users')->where('citizen_id', '=',$request->input('citizen_id') )->value('id_token');

    if (!$token = auth('api')->attempt($credentials)) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    else{
    $user = user::find($id);
    $user->remeber_token=$token;
    $user->save();
    }
    return response()->json([
        'id_token' => $id_token,
        'remember_token' => $token,
        'expires' => auth('api')->factory()->getTTL() * 60,
    ]);

}
 
    //建立新user
    public function store(Request $request)   
    {
         $this->validate($request,[
            'user_name'=>'required',
            'mobile'=>'required',
            'email'=>'required',
            'citizen_id'=>'required',
            'password'=>'required'
     ]); 
         
      if(empty(DB::table('users')->where('citizen_id', '=',$request->input('citizen_id') )->value('citizen_id'))==true){
         $id_token=bcrypt($request->input('citizen_id'));
         $user = new user();
         $user->user_name= $request->input('user_name');
         $user->mobile= $request->input('mobile');
         $user->email= $request->input('email');
         $user->citizen_id= $request->input('citizen_id');
         $user->password= bcrypt($request->input('password'));
         $user->id_token= $id_token;
         $user->save();
         $credentials = request(['citizen_id', 'password']);
        try 
        { $token = auth('api')->attempt($credentials);

         $this->storerem_token($id_token,$token);
       }
       catch (Exception $e) {
        
       return  response()->json([
            'error' => $e->getMessage()
        
]);
       }
         	
         return response()->json([
            'id_token' => $id_token,
            'status' => '1'
        
]);}
         else
         	return response()->json([
            'error' => 'citizen_id exist',
            'status' => '0'
        
]);
        
    
    }
     public function storerem_token($id_token,$token) {
            $id= DB::table('users')->where('id_token', '=',$id_token )->value('id');
         	$user = user::find($id);
            $user->remeber_token=$token;
            $user->save();
         }
      

    //修改資料
    public function update (Request $request){
        $id=$request->get('remeber_token');
        if(!empty($id)){
        $user = User::find($id);
        $user->user_name = $request->input('user_name');
        $user->mobile = $request->input('mobile');
        $user->email = $request->input('email');
        $user->save();
        return response()->json([
            'status' => '1'
]);}
        else
        	return response()->json([
            'status' => '0'
]);
                
    }
   

    //修改密碼
    public function updatepassword (Request $request){
    	$id=$request->get('remeber_token');
        $old=$request->input('oldpassword');
        if(!empty($id)){
        $user = User::find($id);
        if(Hash::check($old,$user->password)){
        	$user->password = bcrypt($request->input('newpassword')); //舊密碼
        	$user->save();
        	return response()->json([
            'status' => '1'
		]);	}
        }
        else{
        	return response()->json([
        	'error'=>'doesn`t comply',
            'status' => '0'
		]);	
        }
    }

}
