<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laundry_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('queue_number');
            $table->string('customer_name');
            $table->string('contact_number');
            $table->decimal('weight_kg', 5, 2);
            $table->enum('service_type', ['ordinary', 'rush']);
            $table->json('addons')->nullable();          // e.g. ["Tide","Downy"]
            $table->decimal('total_price', 8, 2)->default(0);
            $table->string('qr_code')->nullable();
            $table->enum('status', ['pending', 'processing', 'complete'])->default('pending');
            $table->timestamp('received_at')->useCurrent();
            $table->timestamp('estimated_finish')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laundry_orders');
    }
};