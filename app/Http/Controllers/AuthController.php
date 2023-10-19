<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use App\Traits\HttpResponses;

class AuthController extends Controller
{
    // use HttpResponses;

    public function register(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'gender' => 'required|string',
            'city' => 'required|string',
            'profile_image' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'username' => 'required|string|unique:users,username|max:15',
            'password' => 'required|string|confirmed|min:8',
            // 'password_confirmation' => 'required|string|min:8',
        ], [
            'profile_image.max' => 'Image size must not exceed 5 MB',
            'profile_image.mimes' => 'Image formats allowed are jpg,jpeg,png',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $newImageName = time() . '-' . $request->username . '.' . $request->profile_image->extension();
        $request->profile_image->move(public_path('images'), $newImageName);

        $validatedData = $request->all();
        $validatedData['profile_image'] = env('APP_URL').'/images/'.$newImageName;

        $user = User::create($validatedData);

        return response()->json([
            'message' => 'You have successfully created an account',
            'user' => $user,
        ], 200);

    }

    public function login(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid login credentials'
            ], 401);
        }

        $token = $user->createToken('mobile')->plainTextToken;
        return response()->json([
            'message' => 'You have successfully logged in',
            'user' => $user,
        ], 200);
    }
}
