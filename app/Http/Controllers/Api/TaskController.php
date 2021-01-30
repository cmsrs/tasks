<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use Validator;
use App\Models\Task;

class TaskController extends Controller
{
    private $validationRules = [
        'name' => 'min:2|max:255|required',
        'points' => 'integer',    
    ];

    public function index()
    {
        $data = Task::getAllTask();

        return response()->json(['success' => true, 'data'=> $data], 200);
    }

    public function create(Request $request)
    {
        $data = $request->only('name', 'points', 'project_id');

        $validator = Validator::make($data, $this->validationRules);
        if ($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()], 200);
        }

        try {
            $task = Task::create($data);
            if (empty($task->id)) {
                throw new \Exception("I cant get task id");
            }
    
        } catch (\Exception $e) {
            Log::error('task add ex: '.$e->getMessage());
            return response()->json(['success'=> false, 'error'=> 'Add task problem - exeption'], 200);
        }

        return response()->json(['success'=> true]);
    }

    public function update(Request $request, $id)
    {
        $task = Task::find($id);

        if (empty($task)) {
            return response()->json(['success'=> false, 'error'=> 'Task not find'], 200);
        }

        $data = $request->only('name', 'points', 'project_id');

        $validator = Validator::make($data, $this->validationRules);
        if ($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()], 200);
        }
  
        try {
            $task->update($data);
        } catch (\Exception $e) {
            Log::error('taks update ex: '.$e->getMessage());
            return response()->json(['success'=> false, 'error'=> 'Update task problem - exeption'], 200);
        }

        return response()->json(['success'=> true], 200);
    }

    public function delete(Request $request, $id)
    {
        $task = Task::find($id);

        if (empty($task)) {
            return response()->json(['success'=> false, 'error'=> 'Task not find'], 200);
        }

        $res = $task->delete();
        if (empty($res)) {
            return response()->json(['success'=> false, 'error'=> 'Delete task problem'], 200);
        }

        return response()->json(['success'=> true], 200);
    }

}
