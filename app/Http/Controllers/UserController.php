<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Get authenticated user info.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userInfo(Request $request)
    {
        try {
            $user = $request->user(); // Get the authenticated user
            return ApiResponse::success($user, 'User info retrieved successfully', 200);
        } catch (Exception $e) {
            return ApiResponse::error('An error occurred while fetching user info', $e->getMessage(), 500);
        }
    }

    /**
     * Create a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        try {
            // Validate the input
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'role' => 'required|string|in:viewer,admin,manager,super_admin,support',
                'profile_picture' => 'nullable|image|max:2048',
            ]);

            if ($validator->fails()) {
                return ApiResponse::error($validator->errors(), 'Validation error', 422);
            }

            // Create the new user
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'profile_picture' => $request->file('profile_picture') ? $request->file('profile_picture')->store('profile_pictures') : null,
            ]);

            return ApiResponse::success($user, 'User created successfully', 201);
        } catch (Exception $e) {
            return ApiResponse::error('An error occurred while creating the user', $e->getMessage(), 500);
        }
    }

    /**
     * Update user details.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            // Find the user by ID
            $user = User::find($id);

            if (!$user) {
                return ApiResponse::error('User not found', 'User not found', 404);
            }

            // Validate the input
            $validator = Validator::make($request->all(), [
                'first_name' => 'nullable|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'email' => 'nullable|email|unique:users,email,' . $id,
                'role' => 'nullable|string|in:user,admin,manager,super_admin,support',
                'profile_picture' => 'nullable|image|max:2048',
            ]);

            if ($validator->fails()) {
                return ApiResponse::error($validator->errors(), 'Validation error', 422);
            }

            // Update the user details
            $user->update([
                'first_name' => $request->first_name ?? $user->first_name,
                'last_name' => $request->last_name ?? $user->last_name,
                'email' => $request->email ?? $user->email,
                'role' => $request->role ?? $user->role,
                'profile_picture' => $request->file('profile_picture') ? $request->file('profile_picture')->store('profile_pictures') : $user->profile_picture,
            ]);

            return ApiResponse::success($user, 'User updated successfully', 200);
        } catch (Exception $e) {
            return ApiResponse::error('An error occurred while updating the user', $e->getMessage(), 500);
        }
    }

    /**
     * Delete a user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        try {
            // Find the user by ID
            $user = User::find($id);

            if (!$user) {
                return ApiResponse::error('User not found', 'User not found', 404);
            }

            // Delete the user
            $user->delete();

            return ApiResponse::success(null, 'User deleted successfully', 200);
        } catch (Exception $e) {
            return ApiResponse::error('An error occurred while deleting the user', $e->getMessage(), 500);
        }
    }
}
