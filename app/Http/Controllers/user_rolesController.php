<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\user_role;

class user_rolesController extends Controller
{
    public function index()
    {
        return user_role::all();                    //檢索所有資料
    }

    public function show(user_role $user_role)
    {
        return $user_role;                          //檢索單筆資料
    }
    public function store(Request $request)
    {
        $user_role = user_role::create($request->all());

        return response()->json($user_role, 201);   //資料新增，回傳201代表資料成功新增
    }
    public function update(Request $request, user_role $user_role)
    {
        $user_role->update($request->all());

        return response()->json($user_role, 200);   //資料更新，回傳200代表OK
    }
    public function delete(user_role $user_role)
    {
        $user_role->delete();

        return response()->json(null, 204);    //資料刪除，回傳204代表動作成功執行不回傳內容
    }
}