<?php

namespace App\Http\Controllers;

use App\Models\Project_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class ProjectController extends Controller
{
    public function store_project(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
        ]);
        if ($validator->fails()) {
            $response = [
                'error' => true,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }
        $input = $request->all();
        $project = Project_details::create($input);
        $response = [
            'success' => true,
            'data' => $project,
            'message' => 'Project created successfully'
        ];
        return response()->json($response, 200);
    }

    public function all_projects(){
        $projects = Project_details::all();
        return response()->json(['success' => true, 'data' => $projects, 'message' => "Success"], 200);
    }

    public function project_detail(Request $request){
        $validator = Validator::make($request->all(), [
            'project_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }
        $input = $request->all();

        $project = DB::table('project_details')
                    ->join('chats', 'chats.project_id', '=', 'project_details.id')
                    ->join('chat_details', 'chats.id', '=', 'chat_details.chat_id')
                    ->select('chat_details.id as id', 'project_details.id as Project ID', 'project_details.name as Project Name', 'chats.id as chat_id', 'chat_details.input as input', 'chat_details.output as output')
                    ->where('project_details.id', '=', $input['project_id'])
                    ->get();
        $response = [
            'success' => true,
            'data' => $project
        ];
        return response()->json($response, 200);
    }
}
