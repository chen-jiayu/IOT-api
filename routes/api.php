<?php

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use App\user;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });




Route::post('login', 'loginController@inrolecheck'); //登入
Route::post('new', 'loginController@store');//建立新帳號
Route::get('user/{id}', 'userController@show');//顯示個人資料
Route::get('userworkspace/{id}', 'userController@showworkspace');//顯示個人蝦場
Route::put('profile/{id}', 'loginController@update');//修改資料
Route::put('password/{id}', 'loginController@updatepassword');//變更密碼
Route::post('workspace/{userid}', 'workspacesController@store'); //建立養殖場
Route::put('changeworkspace/{workspace}', 'workspacesController@show'); //變換蝦場
Route::post('checktoken', 'loginController@checktoken');
Route::middleware('jwt.auth')->get('users', function () {
    return auth('api')->user();
});

//Route::get('workspace/{id}', 'workspacesController@show');


