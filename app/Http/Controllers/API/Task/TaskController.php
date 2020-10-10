<?php

namespace App\Http\Controllers\API\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Task\CreateTaskListRequest;
use App\Models\Task;
use App\Models\TaskList;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
    public function store()
    {
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
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
                        'status' => 200
                    ]);
                }
            }
        }

        return response()->json([
            'status'    => 200
        ]);
    }
}
