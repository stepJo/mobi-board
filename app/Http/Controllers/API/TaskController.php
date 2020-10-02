<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('lists')->get();

        return response()->json([
            'tasks' => $tasks,
            'status' => 200
        ]);
    }
}
