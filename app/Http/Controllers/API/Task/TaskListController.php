<?php

namespace App\Http\Controllers\API\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Task\CreateTaskListRequest;
use App\Http\Requests\Task\UpdateTaskListRequest;
use App\Models\Task;
use App\Models\TaskList;

class TaskListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTaskListRequest $request)
    {
        try
        {
            $task_list = TaskList::create([
                't_id'           => $request->t_id,
                'tl_title'       => $request->tl_title,
                'tl_description' => $request->tl_description
            ]);

            return response()->json([
                'task_list' => $task_list,
                'status'    => 200
            ], 200);
        }
        catch(Exception $e)
        {
            return response()->json([
                'error' => $e->getMessage(),
                'status' => 400
            ], 400);
        }
    }

    public function show(Request $request) {
        try
        {
            $task_list = TaskList::find($request->tl_id);
            
            return response()->json([
                'task_list' => $task_list,
                'status'    => 200
            ], 200);
        }   
        catch(Exception $e)
        {
            return response()->json([
                'error' => $e->getMessage(),
                'status' => 400
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskListRequest $request)
    {
        try
        {
            $task_list = TaskList::find($request->tl_id);

            $task_list->update([
                'tl_title'       => $request->tl_title,
                'tl_description' => $request->tl_description
            ]);

            return response()->json([
                'task_list' => $task_list,
                'status'    => 200
            ], 200);
        }
        catch(Exception $e)
        {
            return response()->json([
                'error' => $e->getMessage(),
                'status' => 400
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try
        {
            $task_list = TaskList::find($request->tl_id);

            $task_list->delete();

            return response()->json([
                'task_list' => $task_list,
                'status'    => 200
            ], 200);
        }
        catch(Exception $e)
        {
            return response()->json([
                'error' => $e->getMessage(),
                'status' => 400
            ], 400);
        }

    }
}
