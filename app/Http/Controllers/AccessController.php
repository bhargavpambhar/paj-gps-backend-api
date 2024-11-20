<?php

namespace App\Http\Controllers;

use App\Models\Access;
use App\Models\User;
use App\Models\Device;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Validator;

class AccessController extends Controller
{
    /**
     * Get all access for a specific user.
     *
     * @param  int  $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserAccess($userId)
    {
        try {
            // Find the user
            $user = User::find($userId);

            if (!$user) {
                return ApiResponse::error('User not found', 'User not found', 404);
            }

            // Get access details for the user
            $access = $user->access()->with('device')->get();

            return ApiResponse::success($access, 'Device Access records for the user retrieved successfully', 200);
        } catch (\Exception $e) {
            return ApiResponse::error('An error occurred', $e->getMessage(), 500);
        }
    }

    /**
     * Get all access for a specific device.
     *
     * @param  int  $deviceId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDeviceAccess($deviceId)
    {
        try {
            // Find the device
            $device = Device::find($deviceId);

            if (!$device) {
                return ApiResponse::error('Device not found', 'Device not found', 404);
            }

            // Get access details for the device
            $access = $device->access()->with('user')->get();

            return ApiResponse::success($access, 'Device Access records for the device retrieved successfully', 200);
        } catch (\Exception $e) {
            return ApiResponse::error('An error occurred', $e->getMessage(), 500);
        }
    }

    /**
     * Assign device access to a user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function grantAccess(Request $request)
    {
        try {
            // Validate the input
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
                'device_id' => 'required|exists:devices,id',
                'access_level' => 'required|in:viewer,tracker,manager,admin,super_admin,support',
                'expires_at' => 'nullable|date',
            ]);

            if ($validator->fails()) {
                return ApiResponse::error($validator->errors(), 'Validation error', 422);
            }

            // Find the user and device
            $user = User::find($request->user_id);
            $device = Device::find($request->device_id);

            if (!$user || !$device) {
                return ApiResponse::error('User or Device not found', 'User or Device not found', 404);
            }

            // Grant access
            $access = Access::create([
                'user_id' => $user->id,
                'device_id' => $device->id,
                'access_level' => $request->access_level,
                'expires_at' => $request->expires_at,
            ]);

            return ApiResponse::success($access, 'Access granted successfully', 200);
        } catch (\Exception $e) {
            return ApiResponse::error('An error occurred', $e->getMessage(), 500);
        }
    }

    /**
     * Update the access level for a user/device.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAccess(Request $request, $id)
    {
        try {
            // Validate the input
            $validator = Validator::make($request->all(), [
                'access_level' => 'required|in:viewer,tracker,manager,admin,super_admin,support',
                'expires_at' => 'nullable|date',
            ]);

            if ($validator->fails()) {
                return ApiResponse::error($validator->errors(), 'Validation error', 422);
            }

            // Find the access record
            $access = Access::find($id);

            if (!$access) {
                return ApiResponse::error('Access not found', 'Access not found', 404);
            }

            // Update the access level
            $access->access_level = $request->access_level;
            $access->expires_at = $request->expires_at;
            $access->save();

            return ApiResponse::success($access, 'Access updated successfully', 200);
        } catch (\Exception $e) {
            return ApiResponse::error('An error occurred', $e->getMessage(), 500);
        }
    }

    /**
     * Revoke access for a user on a specific device.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function revokeAccess($id)
    {
        try {
            // Find the access record
            $access = Access::find($id);

            if (!$access) {
                return ApiResponse::error('Access not found', 'Access not found', 404);
            }

            // Delete the access record
            $access->delete();

            return ApiResponse::success(null, 'Access revoked successfully', 200);
        } catch (\Exception $e) {
            return ApiResponse::error('An error occurred', $e->getMessage(), 500);
        }
    }
}
