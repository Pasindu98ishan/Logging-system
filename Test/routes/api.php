<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::get('/user', [UserController::class, 'list']);
Route::put('/users/deactivate/{id}',[UserController::class, 'switch']);
Route::GET('/users/sort/{collunm}',[UserController::class, 'sort']);
Route::patch('/users/update/{id}', [UserController::class, 'update']);
Route::get('/users/preview/{id}', [UserController::class, 'edit'])->name('edit');
Route::group(['middleware' => 'check-permissions'], function () {
   
});
