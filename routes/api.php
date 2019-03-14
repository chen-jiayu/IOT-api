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





Route::post('user', 'loginController@store');//建立新帳號
Route::put('user', 'loginController@update');//修改資料
Route::post('userLogin', 'loginController@checktoken'); //登入
Route::put('userpassword', 'loginController@updatepassword');//變更密碼
Route::get('user', 'userController@show');//顯示個人資料
Route::get('workspace', 'userController@showworkspace');//顯示個人蝦場
Route::post('workspace', 'workspacesController@store'); //建立養殖場
Route::put('workspace', 'workspacesController@show'); //修改正在使用蝦場
// Route::post('checktoken', 'loginController@checktoken');
// Route::middleware('jwt.auth')->get('users', function () {
//     return auth('api')->user();
// });

//Route::get('workspace/{id}', 'workspacesController@show');


