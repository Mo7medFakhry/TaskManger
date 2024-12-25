<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Auth::user()->tasks;
        return response()->json($tasks, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $user_id = Auth::user()->id;
        $validatedData = $request->validated();
        $validatedData['user_id'] = $user_id;
        $tasks = Task::create($validatedData);
        return response()->json($tasks, 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $task = Task::find($id);
        return response($task, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, $id)
    {
        $user_id = Auth::user()->id;
        $task = Task::findOrFail($id);
        if ($task->user_id != $user_id) {
            return response()->json(['message' => 'Unauthurized'], 403);
        }
        $task->update($request->validated());
        return response()->json($task, 201);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return response()->json(null, 204);
    }

    public function getUser($id)
    {
        $user = Task::find($id)->user;
        return response()->json($user, 200);
    }

    public function addCategoryToTask(Request $request, $taskId)
    {
        $task = Task::findOrFail($taskId);
        $task->categories()->attach($request->category_id);
        return response()->json('Categorty attached successfully', 201);
    }

    public function getTaskCategories($taskId)
    {
        $categories = Task::findOrFail($taskId)->categories;
        return response()->json($categories, 200);
    }

    public function getCategoriesTask($category_id)
    {
        $tasks = Category::findOrFail($category_id)->tasks;
        return response()->json($tasks, 200);
    }

    public function getAllTasks()
    {
        $tasks = Task::all();
        return response()->json($tasks, 200);
    }
}
