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
        Schema::create('workers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('labor_cost_id')->nullable()->constrained('contractor_costs')->cascadeOnDelete();
            $table->foreignId('primary_contractor_id')->nullable()->constrained('contractor_costs')->nullOnDelete()->comment('Primary contractor for this worker');

            // Worker Information
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();

            // Employment Details
            $table->enum('labor_type', ['daily', 'contractor', 'skilled', 'unskilled', 'specialist'])->default('daily');
            $table->string('category')->nullable()->comment('mason, carpenter, electrician, plumber, painter, welder, helper, other');
            $table->decimal('daily_wage', 10, 2);

            // Status
            $table->boolean('is_active')->default(true);
            $table->date('hire_date')->nullable();
            $table->date('terminate_date')->nullable();

            // Additional Information
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('primary_contractor_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workers');
    }
};
