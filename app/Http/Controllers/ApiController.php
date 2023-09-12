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
                'name' => 'string|required'
            ]);
            if ($validate->fails()) {
                // return $this->responseMessage('error', $validate->errors()->all()[0], 400);
                return response()->json([
                    'message' => $validate->messages()
            ], 200, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
            }
            $user = User::create(['name' => $request->name]);
            // return $this->responseMessage('success', 'user created successfully ', 201, $user);
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
            $user = User::where('user_id', '=', $user_id)->first();
            if (!$user) {
                // return $this->responseMessage('error', 'no user found',  400);
                return response()->json([
                    'message' => 'no user found'
                ], 404, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
            }
            // return $this->responseMessage('success', 'user data retrieved successfully ',  200, $user);
            return response()->json([
                'data' => $user
            ], 200, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
        } catch (\Throwable $th) {
            // return $this->responseMessage('error', $th->getMessage(),  500);
            return response()->json([
                'message' => $th->getMessage()
            ], 500, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $validate = $this->validateRequest($request);
            if ($validate->fails()) {
                return $this->responseMessage('error', $validate->errors()->all(),  400);
            }
            return $this->updateUserDetails($request);
        } catch (\Throwable $th) {
            return $this->responseMessage('error', $th->getMessage(),  500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $user = User::where('id', '=', $request->user_id)->first();
            if (!$user) {
                return $this->responseMessage('error', 'This user is not found',  400);
            }
            $user->delete();
            return $this->responseMessage('success', 'your account was deleted successfully',  200);
        } catch (\Throwable $th) {
            return $this->responseMessage('error', $th->getMessage(),  500);
        }
    }


    private function updateUserDetails($request)
    {
        $user = User::where('id', '=', $request->user_id)->first();
        if (!$user) {
            return $this->responseMessage('error', 'This user is not found ' . $request->old_name,  400);
        }
        $user->update(['name' => $request->name,]);
        return $this->responseMessage('success', 'user name updated successfully ',  200);
    }



    private function validateRequest(Request $request)
    {
        return Validator::make($request->all(), ['name' => 'required|string|unique:users',]);
    }

    private function responseMessage($status, $message, $status_code, $data = null)
    {
        if ($data == null) {
            return response()->json(['status' => $status, 'message' =>  $message, 'status_code' => $status_code]);
        } else {
            return response()->json([
                'status' => $status, 'data' => $data, 'message' =>  $message,
                'status_code' => $status_code
            ]);
        }
    }
}