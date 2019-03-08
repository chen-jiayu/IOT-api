<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\workspace_user;
use App\workspace;
use App\user;
use DB;

class workspacesController extends Controller
{
    public function index()
    {
        return workspace::all();                    
    }

    public function show($workspace)  //變換蝦場
    {   

        $id = DB::table('workspace_users')->where('workspace_id', $workspace )->value('user_id');
        $user = user::find($id);
        $user->workspace_id=$workspace;
        $user->save();          
        //return $id; 
        return response()->json([
            'id_token' => $id,
            'status' => '1'
]);                       
    }

    public function store(Request $request,$userid)  //建立養殖場，workspace_user新增
    {
        $this->validate($request,[
            'workspace_name'=>'required',
            'invite_code'=>'required'
     ]);
         $name=$request->input('invite_code');
         $invite=DB::table('workspaces') ->pluck('invite_code');
         $a=count($invite);
         for($i=0;$i<$a;$i++){
            if($name===$invite[$i]){
                //return 'code exist,please rename';
                return response()->json([
            //'id_token' => $id,
            'status' => '0'
]); 
            }
         }
         $workspace = new workspace();
         $workspace->workspace_name= $request->input('workspace_name');
         $workspace->invite_code= $request->input('invite_code');
         $workspace->save();
     
         $workspace_user = new workspace_user();
         $workspace_user->user_id=$userid;
         $workspace_user->workspace_id=$workspace->id;
         $workspace_user->save();
          return response()->json([
            //'id_token' => $id,
            'status' => '1'
]); 
       // return response()->json($workspace, 201);   //資料新增，回傳201代表資料成功新增
    }
    public function update(Request $request, workspace $workspace)
    {
        $workspace->update($request->all());

        return response()->json($workspace, 200);   //資料更新，回傳200代表OK
    }
    public function delete(workspace $workspace)
    {
        $workspace->delete();

        return response()->json(null, 204);    //資料刪除，回傳204代表動作成功執行不回傳內容
    }
}