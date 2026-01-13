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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('worker_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('labor_cost_id')->nullable()->comment('Reference to contractor_costs');

            // Attendance Details
            $table->date('attendance_date');
            $table->enum('status', ['present', 'absent', 'leave', 'half_day', 'holiday', 'overtime'])->default('present');

            // Work Details
            $table->decimal('hours_worked', 5, 2)->nullable()->comment('Hours worked (for overtime/half-day)');
            $table->decimal('wage_amount', 10, 2)->nullable()->comment('Calculated wage for this day');

            // Additional Information
            $table->text('notes')->nullable();
            $table->text('work_description')->nullable()->comment('What work was done');

            $table->timestamps();

            // Prevent duplicate attendance records
            $table->unique(['worker_id', 'attendance_date']);
            $table->index(['project_id', 'attendance_date']);
            $table->index('attendance_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
