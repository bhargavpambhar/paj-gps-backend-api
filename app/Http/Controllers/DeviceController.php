<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Validator;

class DeviceController extends Controller
{
    /**
     * List all devices.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $devices = Device::all();
            return ApiResponse::success($devices, 'Devices retrieved successfully', 200);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 'An error occurred while retrieving devices', 500);
        }
    }

    /**
     * Get details of a specific device.
     *
     * @param  int  $deviceId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($deviceId)
    {
        try {
            $device = Device::find($deviceId);

            if (!$device) {
                return ApiResponse::error('Device not found', 'Device not found', 404);
            }

            return ApiResponse::success($device, 'Device retrieved successfully', 200);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 'An error occurred while retrieving the device', 500);
        }
    }

    /**
     * Create a new device.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'model' => 'required|string|max:255',
                'device_unique_id' => 'required|string|unique:devices,device_unique_id',
                'type' => 'required|string',
                'status' => 'required|string|in:active,inactive,error',
                'battery_percentage' => 'nullable|numeric|min:0|max:100',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
                'location_history' => 'nullable|json',
            ]);

            if ($validator->fails()) {
                return ApiResponse::error($validator->errors(), 'Validation error', 422);
            }

            $device = Device::create([
                'name' => $request->name,
                'model' => $request->model,
                'device_unique_id' => $request->device_unique_id,
                'type' => $request->type,
                'status' => $request->status,
                'battery_percentage' => $request->battery_percentage ?? 100,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'location_history' => $request->location_history,
            ]);

            return ApiResponse::success($device, 'Device created successfully', 201);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 'An error occurred while creating the device', 500);
        }
    }

    /**
     * Update a device's details.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $deviceId
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $deviceId)
    {
        try {
            $device = Device::find($deviceId);

            if (!$device) {
                return ApiResponse::error('Device not found', 'Device not found', 404);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'nullable|string|max:255',
                'model' => 'nullable|string|max:255',
                'status' => 'nullable|string|in:active,inactive,error',
                'battery_percentage' => 'nullable|numeric|min:0|max:100',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
                'location_history' => 'nullable|json',
            ]);

            if ($validator->fails()) {
                return ApiResponse::error($validator->errors(), 'Validation error', 422);
            }

            $device->update($request->only(['name', 'model', 'status', 'battery_percentage', 'latitude', 'longitude', 'location_history']));

            return ApiResponse::success($device, 'Device updated successfully', 200);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 'An error occurred while updating the device', 500);
        }
    }

    /**
     * Delete a device.
     *
     * @param  int  $deviceId
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($deviceId)
    {
        try {
            $device = Device::find($deviceId);

            if (!$device) {
                return ApiResponse::error('Device not found', 'Device not found', 404);
            }

            $device->delete();

            return ApiResponse::success(null, 'Device deleted successfully', 200);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 'An error occurred while deleting the device', 500);
        }
    }
}
