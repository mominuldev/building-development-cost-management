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
        Schema::create('finishing_works', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('work_type')->comment('flooring, painting, plumbing, electrical, doors_windows, etc.');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('quantity', 12, 2);
            $table->string('unit')->comment('sq ft, sq meter, running ft, pcs, etc.');
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
        Schema::dropIfExists('finishing_works');
    }
};
