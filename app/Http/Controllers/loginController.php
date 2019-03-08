<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\user;
use App\workspace_user;
use DB;
use Hash;

class loginController extends Controller
{

	public function checktoken() {
    $credentials = request(['citizen_id', 'password']);

    if (!$token = auth('api')->attempt($credentials)) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
   
    return response()->json([
        'token' => $token,
        'expires' => auth('api')->factory()->getTTL() * 60,
    ]);
}
    public function inrolecheck (Request $request){ //登入

    	$this->validate($request,[
            'citizen_id'=>'required',
             'password'=>'required'
     ]);
    	$citizenid=$request->input('citizen_id');
    	$password=$request->input('password');
        $citizen = DB::table('users') ->pluck('citizen_id');
       
        $id= DB::table('users') ->pluck('id');
        $i=count($citizen);
        for($j=0 ; $j<$i ; $j++){ //改where
             if($citizenid===$citizen[$j]){
              	if($password===$pass[$j]){
                return $id[$j];
            }
              }
              else if($j===$i-1&&$citizenid!=$citizen[$j])
              	return 'unroll';
        }
    }

    public function store(Request $request)   //建立新user
    {
         $this->validate($request,[
            'user_name'=>'required',
            'mobile'=>'required',
            'email'=>'required',
            'citizen_id'=>'required',
            'password'=>'required'
     ]); 
         //身分證是否存在
         $c=$request->input('citizen_id');
         $cd = DB::table('users') ->pluck('citizen_id');
         $ii=count($cd);
         for($j=0 ; $j<$ii ; $j++){
             if($c===$cd[$j]){
                //return 'citizen exist';
                return response()->json([
            'citizen' => 'exist',
            'status' => '0'
]);
                 }
            }
         //建新資料
         $user = new user();
         $user->user_name= $request->input('user_name');
         $user->mobile= $request->input('mobile');
         $user->email= $request->input('email');
         $user->citizen_id= $request->input('citizen_id');
         $user->password= bcrypt($request->input('password'));
         $user->id_token= bcrypt($request->input('citizen_id'));
         $user->save();
  
         $citizen=$request->input('citizen_id');
         $citizenid = DB::table('users')->pluck('citizen_id');
         $id=DB::table('users')->pluck('id');
         $a=count($citizenid);
         $b;
         for($i=0;$i<$a;$i++){
         	if($citizen===$citizenid[$i]){
                $b=$id[$i];
         	}
         }
        //回傳資料id
        //return $b;
        //return response()->json('1','123', 201);   //資料新增，回傳201代表資料成功新增

        return response()->json([
            'id_token' => $b,
            'status' => '1'
]);
    }

    public function update (Request $request,$id){
        $user = User::find($id);
        $user->user_name = $request->input('user_name');
        $user->mobile = $request->input('mobile');
        $user->email = $request->input('email');
        $user->save();
        return response()->json([
            
            'status' => '1'
]);
                

    }

    public function updatepassword (Request $request,$id){
        $old=$request->input('oldpassword');

        $user = User::find($id);

        if(Hash::check($old,$user->password)){
        	$user->password = bcrypt($request->input('newpassword')); //舊密碼
        	$user->save();
        	return response()->json([
           
            'status' => '1'
		]);	
        }else{
        	return response()->json([
           
            'status' => '0'
		]);	
        }
       

    }

}
