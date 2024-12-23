<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
        ]);

        return $this->sendSuccessResponse('User registered successfully', $user, 201);
    }

    /**
     * Login a user and issue tokens
     */
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Generate refresh token (optional: store securely if needed)
        $refreshToken = JWTAuth::claims(['refresh' => true])->fromUser(Auth::user());

        $data = [
            'access_token' => $token,
            'refresh_token' => $refreshToken,
            'expires_in' => auth('api')->factory()->getTTL() * 60,
        ];

        return $this->sendSuccessResponse('Login successful', $data);
    }

    /**
     * Forgot Password (Generate OTP)
     */
    public function forget(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $otp = rand(1000, 9999); // Generate a 4-digit OTP

        // Ideally store OTP in the database or cache
        $user = User::where('email', $validated['email'])->first();
        $user->otp = $otp; // Add an `otp` column in the `users` table
        $user->save();

        // Send OTP via email (simulated here)
        // Mail::to($user->email)->send(new OTPMail($otp));

        return response()->json(['message' => 'OTP sent to email']);
    }

    /**
     * Validate OTP
     */
    public function validateCode(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|numeric',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if ($user->otp != $validated['otp']) {
            return response()->json(['error' => 'Invalid OTP'], 400);
        }

        return response()->json(['message' => 'OTP validated successfully']);
    }

    /**
     * Reset Password
     */
    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
            'newPassword' => 'required|string|min:6|confirmed',
        ]);

        $user = User::where('email', $validated['email'])->first();
        $user->password = Hash::make($validated['newPassword']);
        $user->save();

        return response()->json(['message' => 'Password reset successfully']);
    }

    /**
     * Refresh Token
     */
    public function refresh(): JsonResponse
    {
        try {
            $newAccessToken = JWTAuth::refresh();
            return response()->json([
                'access_token' => $newAccessToken,
                'expires_in' => auth('api')->factory()->getTTL() * 60,
            ]);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Unable to refresh token'], 401);
        }
    }

    /**
     * Logout and invalidate tokens
     */
    public function logout()
    {
        try {
            auth('api')->logout();
            return response()->json(['message' => 'Logged out successfully']);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Failed to logout'], 500);
        }
    }

    /**
     * Get the authenticated user
     */
    public function me(): JsonResponse
    {
        return response()->json(auth()->user());
    }
}

