<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('energy_measurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->constrained('devices')->onDelete('cascade');
            $table->decimal('voltage', 8, 2);        // Volt
            $table->decimal('current', 8, 2);        // Ampere
            $table->decimal('power', 8, 2);          // Watt
            $table->decimal('energy', 12, 2);        // kWh
            $table->decimal('frequency', 6, 2);      // Hz
            $table->decimal('power_factor', 4, 2);   // 0.00 - 1.00
            $table->decimal('temperature', 5, 2);    // Celsius
            $table->decimal('humidity', 5, 2);       // Persentase
            $table->timestamp('measured_at');
            $table->timestamps();

            // Index untuk pencarian cepat
            $table->index(['device_id', 'measured_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('energy_measurements');
    }
};
