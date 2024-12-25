<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('profile')->group(function(){
    Route::post('', [ProfileController::class, 'store']);
    Route::get('/{id}', [ProfileController::class, 'show']);
    Route::put('/{id}', [ProfileController::class, 'update']);

});

    Route::get('user/{id}/profile', [UserController::class, 'getprofile']);
    Route::get('user/{id}/tasks', [UserController::class, 'getUserTasks']);


    Route::apiResource('tasks', TaskController::class);

    Route::get('task/all', [TaskController::class,'getAllTasks'])->middleware('isAdmin');
    Route::get('task/{id}/user', [TaskController::class, 'getUser']);
    Route::post('tasks/{taskId}/categories', [TaskController::class, 'addCategoryToTask']);
    Route::get('tasks/{taskId}/categories', [TaskController::class, 'getTaskCategories']);
    Route::get('categories/{category_id}/tasks', [TaskController::class, 'getCategoriesTask']);
});
