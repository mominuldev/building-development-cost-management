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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();

            // External recipient information
            $table->string('recipient_name');
            $table->string('recipient_phone')->nullable();
            $table->string('recipient_address')->nullable();
            $table->string('recipient_nid')->nullable()->comment('National ID or Identity document');

            // Loan details
            $table->decimal('amount', 15, 2);
            $table->date('loan_date');
            $table->string('payment_method')->default('cash');
            $table->string('transaction_reference')->nullable();
            $table->enum('status', ['pending', 'partial', 'paid'])->default('pending');
            $table->decimal('amount_repaid', 15, 2)->default(0);
            $table->date('due_date')->nullable();
            $table->decimal('interest_rate', 5, 2)->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
