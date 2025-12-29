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
        Schema::create('labor_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->enum('labor_type', ['daily', 'contractor', 'skilled', 'unskilled', 'specialist']);
            $table->string('name')->nullable();
            $table->string('category')->nullable()->comment('mason, carpenter, electrician, plumber, etc.');
            $table->integer('number_of_workers')->default(1);
            $table->decimal('daily_wage', 10, 2);
            $table->integer('days_worked');
            $table->decimal('total_cost', 15, 2);
            $table->date('work_date');
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labor_costs');
    }
};
