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
            $table->boolean('is_attendance_based')->default(false)->after('notes');
            $table->decimal('calculated_total', 15, 2)->nullable()->after('total_cost')->comment('Recalculated from attendance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('labor_costs', function (Blueprint $table) {
            $table->dropColumn(['is_attendance_based', 'calculated_total']);
        });
    }
};
