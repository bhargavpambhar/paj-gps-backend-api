<?php

namespace Database\Seeders;

use App\Models\Device;
use Illuminate\Database\Seeder;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $devices = [
            [
                'name' => 'GPS Tracker for Cars',
                'model' => 'Car Finder 4G',
                'device_unique_id' => 'car-gps-001',
                'type' => 'Car',
                'status' => 'active',
                'battery_percentage' => 100,
                'latitude' => 12.9716,
                'longitude' => 77.5946,
                'location_history' => json_encode([
                    ['latitude' => 12.9716, 'longitude' => 77.5946],
                    ['latitude' => 12.9700, 'longitude' => 77.6000],
                ]),
            ],
            [
                'name' => 'GPS Tracker for Kids',
                'model' => 'Kid Tracker 4G',
                'device_unique_id' => 'kid-gps-001',
                'type' => 'Kid',
                'status' => 'active',
                'battery_percentage' => 95,
                'latitude' => 18.5204,
                'longitude' => 73.8567,
                'location_history' => json_encode([
                    ['latitude' => 18.5204, 'longitude' => 73.8567],
                    ['latitude' => 18.5200, 'longitude' => 73.8500],
                ]),
            ],
            [
                'name' => 'GPS Tracker for Motorcycle',
                'model' => 'Motorbike Finder 4G 2.0',
                'device_unique_id' => 'bike-gps-001',
                'type' => 'Bike',
                'status' => 'inactive',
                'battery_percentage' => 88,
                'latitude' => 22.5726,
                'longitude' => 88.3639,
                'location_history' => json_encode([
                    ['latitude' => 22.5726, 'longitude' => 88.3639],
                    ['latitude' => 22.5700, 'longitude' => 88.3600],
                ]),
            ],
            [
                'name' => 'GPS Tracker for Truck',
                'model' => 'Truck Finder 4G 1.0',
                'device_unique_id' => 'truck-gps-001',
                'type' => 'Truck',
                'status' => 'active',
                'battery_percentage' => 100,
                'latitude' => 28.6139,
                'longitude' => 77.2090,
                'location_history' => json_encode([
                    ['latitude' => 28.6139, 'longitude' => 77.2090],
                    ['latitude' => 28.6150, 'longitude' => 77.2100],
                ]),
            ],
            [
                'name' => 'GPS Tracker for Dogs',
                'model' => 'Dog Tracker Easy Finder',
                'device_unique_id' => 'dog-gps-001',
                'type' => 'Dog',
                'status' => 'active',
                'battery_percentage' => 95,
                'latitude' => 34.0522,
                'longitude' => -118.2437,
                'location_history' => json_encode([
                    ['latitude' => 34.0522, 'longitude' => -118.2437],
                    ['latitude' => 34.0500, 'longitude' => -118.2400],
                ]),
            ],
            [
                'name' => 'GPS Tracker for Other Areas',
                'model' => 'Finder for Other Areas 4G',
                'device_unique_id' => 'other-area-gps-001',
                'type' => 'Other',
                'status' => 'inactive',
                'battery_percentage' => 80,
                'latitude' => 40.7128,
                'longitude' => -74.0060,
                'location_history' => json_encode([
                    ['latitude' => 40.7128, 'longitude' => -74.0060],
                    ['latitude' => 40.7100, 'longitude' => -74.0050],
                ]),
            ],
        ];

        foreach ($devices as $device) {
            Device::create($device);
        }
    }
}
