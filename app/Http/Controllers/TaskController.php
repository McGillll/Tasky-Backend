<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use DB;

class TaskController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $task = Task::all();
        return response()->json([
            'data' => $task
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskStoreRequest $request)
    {
        $task = new Task();
        $task->title = $request->title;
        $task->description = $request->description;
        $task->deadline = $request->deadline;
        $task->creator = $request->creator;
        $task->status = 'Pending';
        $task->active = 'true';
        $task->save();

        return response()->json([
            'data' => $task
        ],200);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::where('uuid', $id)->first();
        return response()->json([
            'data'=>$task
        ], 200);
    }

    public function getTaskByCreator(string $managerId, string $active){
        $task = Task::where('creator', $managerId)
                        ->where('active', $active)
                        ->orderBy('deadline')
                        ->get();
        return response()->json([
            'data'=>$task
        ], 200);
    }
    public function getTaskByActive(string $active){
        $task = Task::where('active', $active)
                    ->get();
        return response()->json([
            'data'=>$task
        ], 200);
    }
    public function getTaskByTitle(string $title, string $active){
        $task = DB::select("SELECT * FROM tasks WHERE title LIKE '%$title%' AND active = '$active' ORDER BY deadline");
        return response()->json([
            'data' => $task
        ],200);
    }
    public function getTaskByCreatorAndTitle(string $creator, string $title, string $active){
        $task = DB::select("SELECT * FROM tasks WHERE title LIKE '%$title%' AND creator = '$creator' AND active = '$active' ORDER BY deadline");
        return response()->json([
            'data' => $task
        ],200);
    }

    public function getCreatorTaskByStatusAndTitle(string $creator ,string $status, string $title, string $active){
        $tasks = Task::where('creator', $creator)
                    ->where('status', $status)
                    ->where('title', 'like' , '%'.$title.'%')
                    ->where('active' , $active)
                    ->orderBy('deadline')
                    ->get();
        return response()->json([
            'data' => $tasks
        ],200);
    }
    public function getAllTaskByStatusAndTitle(string $status, string $title, string $active){
        $tasks = Task::where('status', $status)
                    ->where('title', 'like' , '%'.$title.'%')
                    ->where('active', $active)
                    ->orderBy('deadline')
                    ->get();
        return response()->json([
            'data' => $tasks
        ],200);
    }

    public function getTotalTaskByCreator(string $managerId){
        $task = Task::where('creator', $managerId)->count();
        return response()->json([
            'data'=>$task
        ], 200);
    }

    public function getNumberOfTask(){
        $users = Task::all()->count();
        return response()->json([
            'data' => $users
        ], 200);
    }

    public function getTotalTaskByStatus(string $status){
        $users = Task::where('status', $status)->count();
        return response()->json([
            'data' => $users
        ], 200);
    }
    public function getTotalTaskByCreatorAndStatus(string $status, string $creator){
        $users = Task::where('status', $status)
                    ->where('creator', $creator)
                    ->count();
        return response()->json([
            'data' => $users
        ], 200);
    }
    public function getTaskByStatus(string $status, string $active){
        $users = Task::where('status', $status)
                    ->where('active', $active)
                    ->orderBy('deadline')
                    ->get();
        return response()->json([
            'data' => $users
        ], 200);
    }
    public function getTaskByCreatorAndStatus(string $status, string $creator, string $active){
        $users = Task::where('status', $status)
                    ->where('creator', $creator)
                    ->where('active', $active)
                    ->orderBy('deadline')
                    ->get();
        return response()->json([
            'data' => $users
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskUpdateRequest $request, string $id)
    {
        $task = Task::findOrFail($id);
        $task->title = $request->title;
        $task->description = $request->description;
        $task->deadline = $request->deadline;
        $task->status = $request->status;
        $task->save();

        return response()->json(['date'=>$task->fresh()],200);
    }

    public function changeStatus(string $id){
        $task = Task::find($id);
        if($task->status === 'Completed'){
            $task->status = 'Pending';
        }else{
            $task->status = 'Completed';
        }
        $task->save();

        return response()->json([
            'data' => $task->fresh(),
            'message' => 'Status update successfully'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::find($id);
        if($task->active === 'true'){
            $task->active = 'false';
        }else{
            $task->active = 'true';
        }
        $task->save();

        return response()->json([
            'data' => $task->fresh(),
            'message' => 'Active update successfully'
        ],200);
    }
}
