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

Route::group([], function () {
    Route::get('/tasks', 'API\Task\TaskController@index');
    Route::patch('/task/sync', 'API\Task\TaskController@sync');
    Route::post('/task_list/store', 'API\Task\TaskListController@store');
    Route::patch('task_list/{task_list}/update', 'API\Task\TaskListController@update');
    Route::delete('task_list/{task_list}/destroy', 'API\Task\TaskListController@destroy');
});
