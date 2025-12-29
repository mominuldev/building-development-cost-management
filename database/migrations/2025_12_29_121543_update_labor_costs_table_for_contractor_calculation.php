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
        Schema::table('labor_costs', function (Blueprint $table) {
            // Make these fields nullable for contractors
            $table->integer('number_of_workers')->nullable()->change();
            $table->decimal('daily_wage', 10, 2)->nullable()->change();
            $table->integer('days_worked')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('labor_costs', function (Blueprint $table) {
            $table->integer('number_of_workers')->nullable(false)->change();
            $table->decimal('daily_wage', 10, 2)->nullable(false)->change();
            $table->integer('days_worked')->nullable(false)->change();
        });
    }
};
