<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('user', 'userController@index');
// Route::get('user/{user}', 'userController@show');
// // Route::post('user', 'userController@store');
// Route::put('user/{user}', 'userController@update');
// Route::delete('user/{user}', 'userController@delete');

Route::get('use_role', 'user_rolesController@index');
Route::get('use_role/{use_role}', 'user_rolesController@show');
Route::post('use_role', 'user_rolesController@store');
Route::put('use_role/{use_role}', 'user_rolesController@update');
Route::delete('use_role/{use_role}', 'user_rolesController@delete');

Route::get('workspace', 'workspacesController@index');
Route::get('workspace/{workspace}', 'workspaceController@show');
Route::post('workspace', 'workspaceController@store');
Route::put('workspace/{workspace}', 'workspaceController@update');
Route::delete('workspace/{workspace}', 'workspaceController@delete');

Route::get('workspace_user', 'workspace_usersController@index');
Route::get('workspace_user/{workspace_user}', 'workspace_usersController@show');
Route::post('workspace_user', 'workspace_usersController@store');
Route::put('workspace_user/{workspace_user}', 'workspace_usersController@update');
Route::delete('workspace_user/{workspace_user}', 'workspace_usersController@delete');

Route::get('option', 'optionController@index');
Route::get('option/{option}', 'optionController@show');
Route::post('option', 'optionController@store');
Route::put('option/{option}', 'optionController@update');
Route::delete('user/{user}', 'optionController@delete');

