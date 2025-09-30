<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('services', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true);
            $table->string('folio', 30);
            $table->foreignId('client_id')->constrained('clients')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('device_id')->constrained('devices')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('assigned_tech_id')->nullable()->constrained('users')->nullOnDelete()->cascadeOnUpdate();
            $table->dateTime('received_at');
            $table->text('reported_issue');
            $table->text('diagnosis')->nullable();
            $table->text('solution')->nullable();
            $table->decimal('estimated_cost', 10, 2)->nullable();
            $table->decimal('final_cost', 10, 2)->nullable();
            $table->unsignedSmallInteger('warranty_days')->default(0);
            $table->dateTime('delivered_at')->nullable();
            $table->unsignedSmallInteger('current_status_id');
            $table->text('notes')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unique('folio', 'uq_services_folio');
            $table->index('client_id', 'idx_services_client_id');
            $table->index('device_id', 'idx_services_device_id');
            $table->index('assigned_tech_id', 'idx_services_assigned_tech_id');
            $table->index('current_status_id', 'idx_services_current_status_id');
            $table->index('received_at', 'idx_services_received_at');

            $table->foreign('current_status_id')->references('id')->on('service_statuses')->restrictOnDelete()->cascadeOnUpdate();
        });
    }
    public function down(): void { Schema::dropIfExists('services'); }
};
