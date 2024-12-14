<?php

namespace App\Http\Controllers;

use App\Models\EmployeeTask;
use App\Http\Requests\StoreEmployeeTaskRequest;
use App\Http\Requests\UpdateEmployeeTaskRequest;
use DB;

class EmployeeTaskController
{
    public function getEmployeePerTask(){
        $taskDetail = DB::select('SELECT u.name, u.profile FROM `employee_tasks` as et
                                INNER JOIN `tasks` as t ON et.taskId = t.id
                                INNER JOIN `users` as u ON et.employeeId = u.id ORDER BY name');
        return response()->json([
            'data' => $taskDetail
        ],200);
    }

    public function getTasksByEmployee(string $employeeId){
        $taskDetail = DB::select("SELECT t.* FROM `employee_tasks` as et
        INNER JOIN `tasks` as t ON et.taskId = t.id
        INNER JOIN `users` as u ON et.employeeId = u.id
        WHERE employeeId = $employeeId AND active = 'true' ORDER BY deadline");

        return response()->json([
            'data' => $taskDetail
        ],200);
    }
    public function getTasksByEmployeeAndStatus(string $employeeId, string $status){
        $taskDetail = DB::select("SELECT t.* FROM `employee_tasks` as et
        INNER JOIN `tasks` as t ON et.taskId = t.id
        INNER JOIN `users` as u ON et.employeeId = u.id
        WHERE employeeId = $employeeId AND status = '$status' AND active = 'true' ORDER BY deadline");

        return response()->json([
            'data' => $taskDetail
        ],200);
    }
    public function getTasksByEmployeeAndTitle(string $employeeId, string $title){
        $taskDetail = DB::select("SELECT t.* FROM `employee_tasks` as et
        INNER JOIN `tasks` as t ON et.taskId = t.id
        INNER JOIN `users` as u ON et.employeeId = u.id
        WHERE employeeId = $employeeId AND title LIKE '%$title%' AND active = 'true' ORDER BY deadline");

        return response()->json([
            'data' => $taskDetail
        ],200);
    }
    public function getEmployeeTasksByStatusAndTitle(string $employeeId, string $title, string $status){
        $taskDetail = DB::select("SELECT t.* FROM `employee_tasks` as et
        INNER JOIN `tasks` as t ON et.taskId = t.id
        INNER JOIN `users` as u ON et.employeeId = u.id
        WHERE employeeId = $employeeId AND title LIKE '%$title%' AND status = '$status' AND active = 'true' ORDER BY deadline");

        return response()->json([
            'data' => $taskDetail
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeTaskRequest $request)
    {
        $data = new EmployeeTask();
        $data->employeeId = $request->employeeId;
        $data->taskId = $request->taskId;
        $data->save();

        return response()->json([
            'data' => $data
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $taskDetail = DB::select('SELECT u.name, u.profile, u.id, u.email FROM `employee_tasks` as et
        INNER JOIN `tasks` as t ON et.taskId = t.id
        INNER JOIN `users` as u ON et.employeeId = u.id
        WHERE t.id = '.$id);
        return response()->json([
            'data' => $taskDetail
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeTaskRequest $request, EmployeeTask $employeeTask)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $employeeId, string $taskId)
    {

    }

    public function removeEmployeeInTask(string $employeeId, string $taskId){
        $result = DB::table('employee_tasks')
                            ->where('employeeId', $employeeId)
                            ->where('taskId', $taskId)
                            ->delete();
        if($result > 0){
            return response()->json(['message' => 'Row deleted '.$result], 200);
        }
    }
}
