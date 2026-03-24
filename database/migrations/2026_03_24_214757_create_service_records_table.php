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
    Schema::create('service_records', function (Blueprint $table) {
        $table->id();

        $table->foreignId('worker_id')->constrained()->cascadeOnDelete();
        $table->foreignId('service_id')->constrained()->cascadeOnDelete();
        $table->foreignId('payment_method_id')->nullable()->constrained()->nullOnDelete();
        $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();

        $table->date('service_date');
        $table->time('start_time')->nullable();
        $table->time('end_time')->nullable();

        $table->decimal('service_price', 12, 2)->default(0);

        $table->decimal('room_cost', 12, 2)->default(0);
        $table->decimal('security_cost', 12, 2)->default(0);
        $table->decimal('advance_payment', 12, 2)->default(0);
        $table->decimal('additional_cost', 12, 2)->default(0);
        $table->decimal('night_cost', 12, 2)->default(0);
        $table->decimal('wipes_cost', 12, 2)->default(0);
        $table->decimal('fine_amount', 12, 2)->default(0);

        $table->text('fine_description')->nullable();
        $table->text('notes')->nullable();

        $table->decimal('total_discounts', 12, 2)->default(0);
        $table->decimal('net_total', 12, 2)->default(0);
        $table->decimal('owner_total', 12, 2)->default(0);
        $table->decimal('worker_total', 12, 2)->default(0);
        $table->decimal('pending_balance', 12, 2)->default(0);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_records');
    }
};
