<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class ChatController extends Controller
{
    public function create_chat(Request $request){
        $validaor = Validator::make($request->all(), [
            'project_id' => 'required|integer'
        ]);
        if ($validaor->fails()) {
            $response = [
                'error' => true,
                'message' => $validaor->errors()
            ];
            return response()->json($response, 400);
        }

        $input = $request->all();
        $chat = Chat::create($input);
        $response = [
            'success' => true,
            'data' => $chat,    
            'message' => 'Chat created successfully'
        ];

        return response($response, 200);
    }
    public function chat_detail(Request $request){
        $validator = Validator::make($request->all(), [
            'chat_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            $response = [
                'error' => true,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }
        $input = $request->all();

        $chat = DB::table('chat_details')
                    ->select('input as Input', 'output as Output')
                    ->where('id', '=', $input['chat_id'])
                    ->get();
        $response = [
            'sucess' => true,
            'data' => $chat
        ];
        return response()->json($response, 200);
    }
}
