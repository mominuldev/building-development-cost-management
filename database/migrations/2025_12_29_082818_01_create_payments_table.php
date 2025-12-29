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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();

            // Payment recipient - can be contractor or worker
            $table->enum('recipient_type', ['contractor', 'worker']);
            $table->unsignedBigInteger('recipient_id')->comment('ID of labor_cost or worker');

            // Payment details
            $table->decimal('amount', 15, 2);
            $table->date('payment_date');
            $table->enum('payment_method', ['cash', 'bank_transfer', 'check', 'upi', 'other'])->default('cash');
            $table->string('transaction_reference')->nullable();

            // Payment status tracking
            $table->enum('status', ['pending', 'partial', 'paid', 'cancelled'])->default('paid');
            $table->text('notes')->nullable();

            // Period covered (optional)
            $table->date('period_start')->nullable()->comment('Start date of work period this payment covers');
            $table->date('period_end')->nullable()->comment('End date of work period this payment covers');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['project_id', 'recipient_type', 'recipient_id']);
            $table->index('payment_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
