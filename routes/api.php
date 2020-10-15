<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/login', 'API\AuthController@login');
Route::post('/logout', 'API\AuthController@logout');

Route::group(['middleware' => ['auth:sanctum']], function () {
    //TASK
    Route::get('/tasks', 'API\Task\TaskController@index');
    Route::group(['prefix' => 'task'], function() {
        Route::post('/store', 'API\Task\TaskController@store');
        Route::patch('/{task}/update', 'API\Task\TaskController@update');
        Route::delete('/{task}/destroy', 'API\Task\TaskController@destroy');
        Route::patch('/sync', 'API\Task\TaskController@sync');
    });
   
    Route::group(['prefix' => 'task_list'], function() {
        Route::post('/store', 'API\Task\TaskListController@store');
        Route::patch('/{task_list}/update', 'API\Task\TaskListController@update');
        Route::delete('/{task_list}/destroy', 'API\Task\TaskListController@destroy');
    });
});

