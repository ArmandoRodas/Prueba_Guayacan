<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('service_status_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true);
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedSmallInteger('status_id');
            $table->foreignId('changed_by_id')->nullable()->constrained('users')->nullOnDelete()->cascadeOnUpdate();
            $table->text('comment')->nullable();
            $table->dateTime('created_at')->useCurrent(); // solo created_at (bitácora)

            $table->index(['service_id', 'created_at'], 'idx_hist_service_created');
            $table->index('status_id', 'idx_hist_status_id');

            $table->foreign('status_id')->references('id')->on('service_statuses')->restrictOnDelete()->cascadeOnUpdate();
        });
    }
    public function down(): void { Schema::dropIfExists('service_status_histories'); }
};
