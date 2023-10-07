<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Chat_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class ChatGPTController extends Controller
{
    protected $httpClient;
   
    public function __construct()
    {
        $this->httpClient = new Client([
            'base_uri' => 'https://api.openai.com/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . env('CHATGPT_API_KEY'),
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function askToChatGpt(Request $request)
    {
        $message = $request->input('message');
        $response = $this->httpClient->post('chat/completions', [
            'json' => [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are'],
                    ['role' => 'user', 'content' => $message],
                ],
            ],
        ]);
        $chat_id = $request->input('chat_id');
        $output = json_decode($response->getBody(), true)['choices'][0]['message']['content'];
        $chat_details_input = [
            'input' => $message,
            'output' => $output,
            'chat_id' => $chat_id
        ];
        Chat_details::create($chat_details_input);
        $response = [
            'success' => true,
            'data' => $output
        ];
        return response()->json($response, 200);
        // return $output;
    }
}