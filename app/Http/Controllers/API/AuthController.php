<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function register(Request $request)
    {
    // VALIDATES THE INPUT DATA
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'username' => 'required|string|unique:users|min:4|max:50|regex:/^[a-zA-Z0-9_]+$/',
            'email_id' => 'required|string|email|max:255|unique:users,email_id',
            'mobile_number' => 'required|string|min:5|max:15',
            'password' => 'required|string|min:6',
        ]);

    // IF VALIDATION FAILS THEN DISPLAY ERROR
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

    // IF VALIDATION TRUE THEN CREATE USER DATA
        $user = User::create([
            'full_name' => $request->full_name,
            'username' => $request->username,
            'email_id' => $request->email_id,
            'mobile_number' => $request->mobile_number,
            'password' => Hash::make($request->password),
            'date_n_time' => Carbon::now(),
        ]);

    // TOKEN GENERATION FOR AUTHENTICATED USER
        $token = JWTAuth::fromUser($user);

    // Return success response with user data and token
        return response()->json([
            'status' => 'success',
            'message' => [
                'id' => $user->id,
                'token' => $token,
                'full_name' => $user->full_name,
                'username' => $user->username,
                'email_id' => $user->email_id,
                'mobile_number' => $user->mobile_number,
                'date_n_time' => $user->date_n_time,
            ],
        ]);
    }

    public function login(Request $request)
    {
    // Validate input data
        $validator = Validator::make($request->all(), [
            'login_id' => 'required|string',
            'password' => 'required|string',
        ]);

    // ERROR MESSAGE IF FAILS 
        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'message' => $validator->errors()
            ], 422);
        }

    // Attempt to find the user by login_id (username or email)
        $login_id = $request->login_id;
        $password = $request->password;

        $user = User::where('username', $login_id)->orWhere('email_id', $login_id)->first();

    // Check if user exists and verify password
        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json([
                'status' => 'fail',
                'message' => ['error_message' => 'Invalid Login Credentials.']
            ], 401);
        }

    // Generate JWT token for authenticated user
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'status' => 'success',
            'message' => [
                'id' => $user->id,
                'token' => $token,
                'full_name' => $user->full_name,
                'username' => $user->username,
                'email_id' => $user->email_id,
                'mobile_number' => $user->mobile_number,
                'date_n_time' => $user->date_n_time,
            ],
        ]);
    }
}
