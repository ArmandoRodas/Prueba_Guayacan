<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('devices', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true);
            $table->foreignId('client_id')->constrained('clients')->restrictOnDelete()->cascadeOnUpdate();
            $table->unsignedInteger('device_type_id');
            $table->unsignedInteger('brand_id')->nullable();
            $table->string('model', 120)->nullable();
            $table->string('serial_number', 120)->nullable();
            $table->string('imei', 20)->nullable();
            $table->string('accessories', 255)->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->index('client_id', 'idx_devices_client_id');
            $table->index('device_type_id', 'idx_devices_device_type_id');
            $table->index('brand_id', 'idx_devices_brand_id');
            $table->index('serial_number', 'idx_devices_serial_number');
            $table->index('imei', 'idx_devices_imei');

            $table->foreign('device_type_id')->references('id')->on('device_types')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('brand_id')->references('id')->on('brands')->nullOnDelete()->cascadeOnUpdate();
        });
    }
    public function down(): void { Schema::dropIfExists('devices'); }
};
