<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Access;
use App\Models\User;
use App\Models\Device;

class AccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Fetch all users and devices
        $users = User::all();
        $devices = Device::all();

        if ($users->isEmpty() || $devices->isEmpty()) {
            $this->command->error('Users or Devices table is empty. Please seed those tables first.');
            return;
        }

        // Define role-based access levels
        $roleAccessLevels = [
            'admin' => ['admin', 'super_admin'],
            'manager' => ['manager', 'tracker'],
            'support' => ['support', 'viewer'],
            'viewer' => ['viewer', 'tracker'],
        ];

        // Seed the access table based on roles
        foreach ($users as $user) {
            $accessLevels = $roleAccessLevels[$user->role] ?? ['viewer']; // Default to 'viewer' if role not matched

            foreach ($devices->take(2) as $device) { // Assign two devices per user for demo
                Access::create([
                    'user_id' => $user->id,
                    'device_id' => $device->id,
                    'access_level' => collect($accessLevels)->random(),
                    'expires_at' => now()->addDays(rand(30, 90)),
                ]);
            }
        }

        $this->command->info('Access table seeded successfully based on user roles.');
    }
}
