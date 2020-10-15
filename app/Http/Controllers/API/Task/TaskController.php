<?php

namespace App\Http\Controllers\API\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Task\CreateTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Models\Task;
use App\Models\TaskList;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try
        {
            $tasks = Task::with('lists')->get();
            
            return response()->json([
                'tasks' => $tasks,
                'status' => 200
            ]);
        }
        catch(Exception $e)
        {
            return response()->json([
                'errors' => $e->getMessage(),
                'status' => 200
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTaskRequest $request)
    {
        try
        {
            $task = Task::create([
                'u_id'          => auth()->user()->u_id,
                't_title'       => $request->t_title,
                't_description' => $request->t_description
            ]);

            return response()->json([
                'task'   => $task,
                'status' => 200
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskRequest $request, $id)
    {
        try
        {
            $task = Task::find($request->t_id);

            $task->update([
                't_title'       => $request->t_title,
                't_description' => $request->t_description
            ]);

            return response()->json([
                'task'   => $task,
                'status' => 200
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
        try{
            $task = Task::find($request->t_id);

            $task->delete();

            return response()->json([
                'task' => $task,
                'status' => 200
            ]);
        }
        catch(Exception $e)
        {
            return response()->json([
                'errors' => $e->getMessage(),
                'status' => 400
            ], 400);
        }
    }

    public function sync(Request $request) {
        foreach($request->tasks as $task)
        {
            foreach($task['lists'] as $i => $list)
            {
                $order  = $i + 1;

                try 
                {
                    $task_list =TaskList::find($list['tl_id']);

                    $task_list->update([
                        't_id'     => $task['t_id'],
                        'tl_order' => $order
                    ]);
                }
                catch(Exception $e)
                {
                    return response()->json([
                        'errors' => $e->getMessage(),
                        'status' => 400
                    ], 400);
                }
            }
        }

        return response()->json([
            'status'    => 200
        ], 200);
    }
}
