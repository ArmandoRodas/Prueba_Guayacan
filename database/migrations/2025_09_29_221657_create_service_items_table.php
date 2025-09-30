<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('service_items', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true);
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('kind', ['part','labor','other']);
            $table->string('description', 200);
            $table->decimal('quantity', 10, 2)->default(1);
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->decimal('subtotal', 10, 2)->storedAs('`quantity` * `unit_price`');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->index('service_id', 'idx_items_service_id');
        });
    }
    public function down(): void { Schema::dropIfExists('service_items'); }
};
