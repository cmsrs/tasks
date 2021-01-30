<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('login', [AuthController::class, 'login']);
//Route::post('login', 'AuthController@login');

Route::group(['middleware' => ['jwt.auth']], function() {
    Route::get('logout', [AuthController::class, 'logout']);

    Route::get('projects',  [ProjectController::class, 'index']  );
    Route::post('projects',  [ProjectController::class, 'create']  );
    Route::put('projects/{id}',   [ProjectController::class, 'update'] );
    Route::delete('projects/{id}',   [ProjectController::class, 'delete'] );    

    Route::get('tasks',  [TaskController::class, 'index']  );
    Route::post('tasks',  [TaskController::class, 'create']  );
    Route::put('tasks/{id}',   [TaskController::class, 'update'] );
    Route::delete('tasks/{id}',   [TaskController::class, 'delete'] );        
});