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
            $validate = $this->validateRequest($request);
            if ($validate->fails()) {
                return $this->responseMessage('error', $validate->errors()->all()[0], 400);
            }
            $user = User::create(['name' => $request->name]);
            return $this->responseMessage('success', 'user created successfully ', 200, $user);
        } catch (\Throwable $th) {
            return $this->responseMessage('error', $th->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try {
            $user = User::where('id', '=', $request->user_id)->first();
            if (!$user) {
                return $this->responseMessage('error', 'no user found',  400);
            }
            return $this->responseMessage('success', 'user data retrieved successfully ',  200, $user);
        } catch (\Throwable $th) {
            return $this->responseMessage('error', $th->getMessage(),  500);
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