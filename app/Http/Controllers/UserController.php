<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use DB;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();
        return response()->json([
            'data' => $user
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->profile = 'https://tasky-profile.s3.ap-southeast-2.amazonaws.com/' . ($request->file('file')->store('profile'));
        $user->save();

        return response()->json([
            'data' => $user
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::where('uuid', $id)->first();
        if(!$user){
            return response()->json([
                'message' => 'User not found'
            ],404);
        }

        return response()->json([
            'data' => $user
        ], 200);
    }

    public function getCurrentUser() {
        $user = auth()->user();
        return response()->json([
            'data' => $user
        ],200);
    }

    public function getUserByEmail(string $email){
        $user = User::where('email', $email)->first();
        if(!$user){
            return response()->json([
                'message' => 'User not found'
            ],404);
        }
        return response()->json([
            'data' => $user
        ], 200);
    }
    public function getUserById(string $id){
        $user = User::find($id);
        if(!$user){
            return response()->json([
                'message' => 'User not found'
            ],404);
        }
        return response()->json([
            'data' => $user
        ], 200);
    }

    public function getUserByName(string $name){
        $users = DB::select(
            "SELECT * FROM users WHERE role != 'Admin' AND name LIKE '%$name%'
                    ORDER BY name");
        return response()->json([
            'data' => $users
        ],200);
    }

    public function getNumberOfEmployee(){
        $users = User::whereIn('role', ['Employee', 'Manager'])->count();
        return response()->json([
            'data' => $users
        ], 200);
    }
    public function getUserByRole(string $role){
        $users = User::where('role', $role)
                        ->orderBy('name')
                        ->get();
        return response()->json([
            'data' => $users
        ], 200);
    }

    public function getEmployees(){
        $users = User::whereIn('role', ['Employee', 'Manager'])
                        ->orderBy('name')
                        ->get();
        return response()->json([
            'data' => $users
        ], 200);
    }
    public function getEmployeesByName(string $name){
        $users = DB::select("SELECT * FROM users
        WHERE role = 'Employee' AND name LIKE '%$name%' ORDER BY name");
        return response()->json([
            'data' => $users
        ], 200);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(FormRequest $request, string $id)
    {
        $user = User::find($id);
        // Update user fields
        if ($request->name) {
            $user->name = $request->name;
        } if ($request->email) {
            $user->email = $request->email;
        } if ($request->password) {
            $user->password = Hash::make($request->password);
        } if ($request->role) {
            $user->role = $request->role;
        } if ($request->hasFile('file')) {
            // Handle file upload to S3
            $file = $request->file('file');
            $path = $file->store('profile');
            $user->profile = 'https://tasky-profile.s3.ap-southeast-2.amazonaws.com/' . $path;
        } // Save the updated user
        $user->save();
        return response()->json([ 'data' => $request->file ], 200);
    }

    public function updateUser(FormRequest $request, string $id){
        // $user = User::findOrFail($id);
        // // Update user fields
        // if ($request->name) {
        //     $user->name = $request->name;
        // } if ($request->email) {
        //     $user->email = $request->email;
        // } if ($request->password) {
        //     $user->password = Hash::make($request->password);
        // } if ($request->role) {
        //     $user->role = $request->role;
        // } if ($request->hasFile('profile')) {
        //     // Handle file upload to S3
        //     $file = $request->file('file');
        //     $path = $file->store('');
        //     $user->profile = 'https://tasky-profile.s3.ap-southeast-2.amazonaws.com/' . $path;
        // } // Save the updated user
        // $user->save();
        return response()->json([ 'data' => $request->all() ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if(!$user){
            return response()->json([
                'message' => 'No user found'
            ],404);
        }
        return response()->json([
            'message' => 'User deleted'
            ],200);
    }


    //Seed admin account
    public function createAdmin(){
        $user = new User();
        $user->name = 'admin';
        $user->email = 'mcgilibag123@gmail.com';
        $user->password = Hash::make('administrator');
        $user->role = 'admin';
        $user->profile = 'https://tasky-profile.s3.ap-southeast-2.amazonaws.com/admin/cat.jpg';
        $user->save();

        return response()->json($user, 200);
    }
}
