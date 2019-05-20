<?php

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;



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

//user
Route::post('user', 'loginController@store');//建立新帳號
Route::put('user', 'loginController@update');//修改資料
Route::post('userLogin', 'loginController@checktoken'); //登入
Route::put('userpassword', 'loginController@updatepassword');//變更密碼
Route::get('user', 'userController@show');//顯示個人資料
Route::get('userworkspace', 'userController@showworkspace');//顯示個人蝦場
//workspace
Route::post('workspace', 'workspacesController@store'); //建立養殖場
Route::put('workspace', 'workspacesController@show'); //修改正在使用蝦場
Route::post('joinworkspace', 'workspacesController@join');
//supplier
Route::post('supplier', 'supplierController@store');//新增廠商
Route::put('supplier/{supplier_id}', 'supplierController@put');//修改場商
Route::get('supplier/{supplier_id}', 'supplierController@get');//取得場商
Route::get('suppliers', 'supplierController@gets');
//field
Route::post('field', 'fieldController@store');//新增廠區
Route::put('field/{field_id}', 'fieldController@put');//修改廠區
Route::get('field/{field_id}', 'fieldController@get');
Route::get('fields', 'workspacesController@get');
//pond
Route::post('pond', 'pondController@store');//新增水池
Route::put('pond/{pond_id}', 'pondController@put');//修改水池+修改蝦苗資訊
Route::get('pond/{pond_id}', 'pondController@get');//取得水池+蝦苗資訊
//enviroment
Route::post('enviroment', 'enviromentController@store');
Route::get('enviroment/{state_id}/{district_id}/{day}', 'enviromentController@get');
//rainfall
Route::post('rainfall', 'rainfallController@store');
Route::get('rainfall/{state_id}/{district_id}/{time}', 'rainfallController@get');
//air
Route::get('airquality/{state_id}/{istrict_id}/{time}', 'airqualityController@get');
Route::post('airquality', 'airqualityController@store');
//state
Route::post('state', 'stateController@store');//新增縣市
Route::get('states', 'stateController@get');
//pondshrimp
Route::post('pondshrimp', 'pondshrimpController@store');
Route::put('pondshrimp/{pond_id}', 'pondshrimpController@put');
//field_feed
Route::post('field_feed', 'field_feedController@store');
//Route::put('field_feed/{field_feed_id}', 'field_feedController@put');
Route::get('field_feed/{field_feed_id}', 'field_feedController@get');
//field_feed_log
Route::post('field_feed_log', 'field_feed_logController@store');
Route::put('field_feed_log/{field_feed_log_id}', 'field_feed_logController@put');
Route::get('field_feed_log/{field_feed_log_id}', 'field_feed_logController@get');
Route::get('field_feed_logs', 'field_feed_logController@gets');
//daily_note
Route::post('daily_note', 'daily_noteController@store');
Route::put('daily_note/{note_id}', 'daily_noteController@put');
Route::get('daily_note/{note_id}', 'daily_noteController@get');
Route::get('daily_notes','daily_noteController@gets');
//district
Route::get('districts/{state_id}', 'districtController@get');
Route::post('district', 'districtController@store');//新增縣市
//option
Route::get('option/{optid}', 'optionController@get');
Route::post('option', 'optionController@store');



// Route::post('checktoken', 'loginController@checktoken');
// Route::middleware('jwt.auth')->get('users', function () {
//     return auth('api')->user();
// });

//Route::get('workspace/{id}', 'workspacesController@show');


