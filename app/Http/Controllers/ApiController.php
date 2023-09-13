<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->only('name'), [
                'name' => 'string|required|unique:users' 
            ]);
            if ($validate->fails()) {
                return response()->json([
                    'message' => $validate->messages()
            ], 200, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
            }
            $user = User::create(['name' => $request->name]);
            return response()->json([
                'message' => 'new user saved successfully',
                'data' => $user
            ], 201, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($user_id)
    {
        try {
            $user = User::where('id', '=', $user_id)->first();
            if (!$user) {
                return response()->json([
                    'message' => 'no user found'
                ], 404, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
            }
            return response()->json([
                'data' => $user
            ], 200, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update($user_id, Request $request)
    {
        try {
            $user = User::find($user_id);
            if (!$user) {
                return response()->json([
                    'message' => 'no user found'
                ], 404, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
            }
            $name = $request->only('name');
            $validate = Validator::make($name, [
                'name' => 'string|required'
            ]);
            if ($validate->fails()) {
                return response()->json([
                    'message' => $validate->messages()
            ], 200, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
            }
            $user->update($name);
            return response()->json([
                'data' => $user
            ], 200, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($user_id)
    {
        try {
            $user = User::find($user_id);
            if (!$user) {
                return response()->json([
                    'message' => 'no user found'
                ], 404, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
            }
            $user->delete();
            return response()->json([
                'message' => "User deleted successfully"
        ], 204, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
        }
    }

     /**
     * Show All from storage.
     */

    public function viewAll() {
        $users = User::all();
        return response()->json([
            'data' => $users
        ], 200, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
    }
}