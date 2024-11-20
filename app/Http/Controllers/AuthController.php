<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RefreshToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ApiResponse;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Login and return an access token and refresh token.
     */
    public function login(Request $request) {
        try {
            // Validate the incoming request
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {
                return ApiResponse::error($validator->errors(), 'Validation failed', 422);
            }

            // Check if the user exists
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return ApiResponse::error(null, 'Invalid credentials', 401);
            }

            // Create an access token for the user using Sanctum
            $accessToken = $user->createToken('Login Token')->plainTextToken;

            // Create a refresh token as a random string
            $refreshToken = hash('sha256', Str::random(60));

            // Store the refresh token in the database
            RefreshToken::create([
                'user_id' => $user->id,
                'refresh_token' => $refreshToken,
            ]);

            // Return both access and refresh tokens
            return ApiResponse::success([
                'access_token' => $accessToken, // The access token
                'refresh_token' => $refreshToken, // The refresh token
                'token_type' => 'Bearer',
                'expires_in' => 3600, // Token expiration (1 hour)
            ], 'Login successful');
        } catch (\Exception $e) {
            return ApiResponse::error(null, 'An error occurred during login: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get a new login token using the refresh token.
     */
    public function refresh(Request $request) {
        try {
            // Validate the incoming request
            $validator = Validator::make($request->all(), [
                'refresh_token' => 'required|string',
            ]);

            if ($validator->fails()) {
                return ApiResponse::error($validator->errors(), 'Validation failed', 422);
            }

            // Validate if the refresh token exists in the database
            $refreshToken = RefreshToken::where('refresh_token', $request->refresh_token)->first();

            if (!$refreshToken) {
                return ApiResponse::error(null, 'Invalid refresh token', 401);
            }

            // Retrieve the user associated with the refresh token
            $user = $refreshToken->user;

            if (!$user) {
                return ApiResponse::error(null, 'User not found', 404);
            }

            // Issue a new access token
            $newAccessToken = $user->createToken('Login Token')->plainTextToken;

            // Generate a new refresh token
            $newRefreshToken = hash('sha256', Str::random(60));

            // Optionally, delete the old refresh token if you don’t want it to be reused
            $refreshToken->delete();

            // Store the new refresh token in the database
            RefreshToken::create([
                'user_id' => $user->id,
                'refresh_token' => $newRefreshToken,
            ]);

            // Return only the new access token (refresh token is optional in some cases)
            return ApiResponse::success([
                'access_token' => $newAccessToken, // New access token
                'token_type' => 'Bearer',
                'expires_in' => 3600, // Token expiration (1 hour)
            ], 'Token refreshed successfully');
        } catch (\Exception $e) {
            return ApiResponse::error(null, 'An error occurred during token refresh: ' . $e->getMessage(), 500);
        }
    }
}

