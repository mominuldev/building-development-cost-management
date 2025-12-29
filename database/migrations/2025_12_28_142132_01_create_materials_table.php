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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->enum('material_type', ['bricks', 'brick_chips', 'cement', 'steel', 'sand', 'stone', 'other']);
            $table->string('name');
            $table->decimal('quantity', 12, 2);
            $table->string('unit')->comment('pcs, kg, cubic feet, cubic meter, bags, etc.');
            $table->decimal('unit_price', 12, 2);
            $table->decimal('total_cost', 15, 2);
            $table->date('purchase_date');
            $table->string('supplier')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
