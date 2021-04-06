<?php

use App\Http\Controllers\V1\ToolsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('V1')->prefix('v1')->group(function(){
    Route::prefix('tools')->group(function(){
        Route::get('/', [ToolsController::class, 'list']);
        Route::post('/', [ToolsController::class, 'add']);
        Route::get('/{id}', [ToolsController::class, 'get']);
        Route::put('/{id}', [ToolsController::class, 'edit']);
        Route::delete('/{id}', [ToolsController::class, 'delete']);
    });
});