<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('service_statuses', function (Blueprint $table) {
            $table->unsignedSmallInteger('id', true);
            $table->string('code', 40);
            $table->string('label', 120);

            $table->unique('code', 'uq_service_statuses_code');
        });
    }
    public function down(): void { Schema::dropIfExists('service_statuses'); }
};
