<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->string('name'); // Name of the device (e.g., "Car GPS Tracker")
            $table->string('model'); // Model of the device (e.g., "V2.0", "Pro")
            $table->string('device_unique_id')->unique(); // Unique ID for the device
            $table->string('type'); // Type of device (e.g., "Car", "Bike", "Pet", "Kid")
            $table->string('status')->default('active'); // Device status (active, inactive, error, etc.)
            $table->decimal('battery_percentage', 5, 2)->default(100); // Battery percentage
            $table->decimal('latitude', 10, 7)->nullable(); // Last known latitude
            $table->decimal('longitude', 10, 7)->nullable(); // Last known longitude
            $table->timestamp('last_updated_at')->nullable(); // Timestamp of last location update
            $table->json('location_history')->nullable(); // Store a history of locations (in JSON)
            $table->timestamps(); // Created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
