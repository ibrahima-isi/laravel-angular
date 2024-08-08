<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthenticationRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    /**
     * Register a new user
     */

    public function register(AuthenticationRequest $request)
    {
        try {
            $user = $request->all();
            $user['password'] = bcrypt($request->password);
            $user['email_verified_at'] = now();
            $user = User::create($user);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'User created successfully',
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create a new user',
                'error' => $e->getMessage()
            ], 500);
        }

    }

    /**
     * Login a user
     */
    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            if (!auth()->attempt($credentials, $request->filled('remember'))) {
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);
            }

            $user = User::where('email', $request->email)->firstOrFail();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'User logged in successfully',
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer'
            ], status: 200, headers: ['Authorization' => $token]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to login user, check your credentials',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Logout a user
     */
    public function logout(Request $request){
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return response()->json([
                'message' => 'User logged out successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to logout user',
                'error' => $e->getMessage()
            ], 500);
        }

    }
}
