<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeTaskController;
use App\Http\Controllers\S3Controller;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', [AuthController::class, 'authLogin']);
Route::post('/admin/create/account', [UserController::class, 'createAdmin']);

Route::middleware('auth:sanctum')->group(function(){
    Route::apiResources([
        'user' => UserController::class,
        'task' => TaskController::class,
        'taskEmployee' => EmployeeTaskController::class
    ]);
    Route::post('auth/logout', [AuthController::class, 'authLogout']);

    //User Routes
    Route::get('/auth/user/email/{email}', [UserController::class, 'getUserByEmail']);
    Route::get('total/employees', [UserController::class, 'getNumberOfEmployee']);
    Route::get('employees', [UserController::class, 'getEmployees']);
    Route::get('employees/name/{name}', [UserController::class, 'getEmployeesByName']);
    Route::get('current/user', [UserController::class, 'getCurrentUser'] );
    Route::get('user/name/{user}', [UserController::class, 'getUserByName'] );
    Route::get('user/id/{id}', [UserController::class, 'getUserById'] );
    Route::get('user/role/{role}', [UserController::class, 'getUserByRole'] );

    //Task Routes
    Route::get('tasks/active/{active}', [TaskController::class, 'getTaskByActive']);
    Route::get('tasks/title/{title}/{active}', [TaskController::class, 'getTaskByTitle']);
    Route::get('tasks/status/{status}/{active}', [TaskController::class, 'getTaskByStatus']);
    Route::get('tasks/creator/{creator}/{active}', [TaskController::class, 'getTaskByCreator']);
    Route::get('tasks/status/creator/{status}/{creator}/{active}', [TaskController::class, 'getTaskByCreatorAndStatus']);
    Route::get('tasks/status/title/{status}/{title}/{active}', [TaskController::class, 'getAllTaskByStatusAndTitle']);
    Route::get('tasks/creator/title/{creator}/{title}/{active}', [TaskController::class, 'getTaskByCreatorAndTitle']);
    Route::get('tasks/creator/status/title/{creator}/{status}/{title}/{active}', [TaskController::class, 'getCreatorTaskByStatusAndTitle']);
    Route::put('tasks/update/status/{task}', [TaskController::class, 'changeStatus']);

    //Employee Task Routes
    Route::get('employee/profile', [EmployeeTaskController::class, 'getEmployeePerTask']);
    Route::get('employee/tasks/{employee}', [EmployeeTaskController::class, 'getTasksByEmployee']);
    Route::get('employee/tasks/status/{employee}/{status}', [EmployeeTaskController::class, 'getTasksByEmployeeAndStatus']);
    Route::get('employee/tasks/title/{employee}/{title}', [EmployeeTaskController::class, 'getTasksByEmployeeAndTitle']);
    Route::get('employee/tasks/status/title/{employee}/{title}/{status}', [EmployeeTaskController::class, 'getEmployeeTasksByStatusAndTitle']);
    Route::delete('remove/employee/{employee}/{task}', [EmployeeTaskController::class, 'removeEmployeeInTask']);
});



