<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator;
use App\Models\Project;

class ProjectController extends Controller
{

    private $validationRules = [
        'title' => 'min:2|max:255|required'
    ];

    public function index()
    {
        $data = Project::getAllProjects();

        return response()->json(['success' => true, 'data'=> $data], 200);
    }

    public function create(Request $request)
    {
        $data = $request->only('title');

        $validator = Validator::make($data, $this->validationRules);
        if ($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()], 200);
        }

        try {
            $project = Project::create($data);
            if (empty($project->id)) {
                throw new \Exception("I cant get project id");
            }
    
        } catch (\Exception $e) {
            Log::error('project add ex: '.$e->getMessage());
            return response()->json(['success'=> false, 'error'=> 'Add project problem - exeption'], 200);
        }

        return response()->json(['success'=> true]);
    }

    public function update(Request $request, $id)
    {
        $project = Project::find($id);

        if (empty($project)) {
            return response()->json(['success'=> false, 'error'=> 'Project not find'], 200);
        }

        $data = $request->only('title');

        $validator = Validator::make($data, $this->validationRules);
        if ($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()], 200);
        }
  
        try {
            $project->update($data);
        } catch (\Exception $e) {
            Log::error('project update ex: '.$e->getMessage());
            return response()->json(['success'=> false, 'error'=> 'Update project problem - exeption'], 200);
        }

        return response()->json(['success'=> true], 200);
    }

    public function delete(Request $request, $id)
    {
        $project = Project::find($id);

        if (empty($project)) {
            return response()->json(['success'=> false, 'error'=> 'Project not find'], 200);
        }

        $res = $project->delete();
        if (empty($res)) {
            return response()->json(['success'=> false, 'error'=> 'Delete project problem'], 200);
        }

        return response()->json(['success'=> true], 200);
    }
}
