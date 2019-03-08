<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\workspace_user;

class workspace_usersController extends Controller
{
    public function index()
    {
        return workspace_user::all();                    //檢索所有資料
    }

    public function show(workspace_user $workspace_user)
    {
        return $workspace_user;                          //檢索單筆資料
    }
    public function store(Request $request)
    {
        $workspace_user = workspace_user::create($request->all());

        return response()->json($workspace_user, 201);   //資料新增，回傳201代表資料成功新增
    }
    public function update(Request $request, workspace_user $workspace_user)
    {
        $workspace_user->update($request->all());

        return response()->json($workspace_user, 200);   //資料更新，回傳200代表OK
    }
    public function delete(workspace_user $workspace_user)
    {
        $workspace_user->delete();

        return response()->json(null, 204);    //資料刪除，回傳204代表動作成功執行不回傳內容
    }
}