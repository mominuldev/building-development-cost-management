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
        // Create contractor_costs table
        Schema::create('contractor_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->enum('labor_type', ['daily', 'contractor', 'skilled', 'unskilled', 'specialist']);
            $table->string('name')->nullable();
            $table->string('category')->nullable()->comment('mason, carpenter, electrician, plumber, etc.');
            $table->integer('number_of_workers')->nullable();
            $table->decimal('daily_wage', 10, 2)->nullable();
            $table->integer('days_worked')->nullable();
            $table->decimal('total_cost', 15, 2);
            $table->decimal('calculated_total', 15, 2)->nullable()->comment('Recalculated from attendance');
            $table->date('work_date')->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_attendance_based')->default(false);
            $table->boolean('use_uniform_wage')->default(false)->comment('Use same daily wage for all workers');
            $table->decimal('uniform_daily_wage', 10, 2)->nullable()->comment('Fixed daily wage for all workers under this contractor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contractor_costs');
    }
};
