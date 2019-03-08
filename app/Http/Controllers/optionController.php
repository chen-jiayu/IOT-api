<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\option;

class optionController extends Controller
{
    public function index()
    {
        return option::all();                    //檢索所有資料
    }

    public function show(option $option)
    {
        return $option;                          //檢索單筆資料
    }
    public function store(Request $request)
    {
        $option = option::create($request->all());

        return response()->json($option, 201);   //資料新增，回傳201代表資料成功新增
    }
    public function update(Request $request, option $option)
    {
        $option->update($request->all());

        return response()->json($option, 200);   //資料更新，回傳200代表OK
    }
    public function delete(option $option)
    {
        $option->delete();

        return response()->json(null, 204);    //資料刪除，回傳204代表動作成功執行不回傳內容
    }
}