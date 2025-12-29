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
        Schema::create('structure_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->enum('structure_type', ['foundation', 'columns', 'beams', 'slabs', 'roof', 'walls', 'other']);
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('quantity', 12, 2);
            $table->string('unit')->comment('sq ft, sq meter, cubic ft, running ft, etc.');
            $table->decimal('unit_price', 12, 2);
            $table->decimal('total_cost', 15, 2);
            $table->date('work_date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('structure_costs');
    }
};
