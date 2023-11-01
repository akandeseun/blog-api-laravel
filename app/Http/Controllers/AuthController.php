<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password'])
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;


        // sends users a verify email link
        event(new Registered($user));

        return response([
            "message" => "User created",
            "token" => $token
        ]);
    }

    public function login(Request $request)
    {

        $validatedData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (!Auth::attempt($credentials)) {
            return response(["message" => "Invalid Login details"], 400);
        }

        $user = User::where('email', $credentials['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response([
            "data" => [
                "user" => $user,
                "token" => $token
            ]
        ]);
    }

    // public function verifyEmail(EmailVerificationRequest $request)
    // {
    //     $request->fulfill();

    //     return 
    // }
}
