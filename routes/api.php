<?php

use App\Http\Controllers\ChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ChatGPTController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/chat', [ChatGPTController::class, 'askToChatGpt']);

Route::controller(ProjectController::class)->group(function(){
    Route::post('/store-project', 'store_project');
    Route::get('/get-all-projects', 'all_projects');
    Route::post('/get-project-details', 'project_detail');
});

Route::controller(ChatController::class)->group(function(){
    Route::post('/store-chat', 'create_chat');
    Route::post('/get-chat-details', 'chat_detail');
});
