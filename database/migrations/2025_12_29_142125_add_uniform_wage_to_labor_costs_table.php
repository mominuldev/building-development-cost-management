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
            $table->boolean('use_uniform_wage')->default(false)->after('is_attendance_based')->comment('Use same daily wage for all workers');
            $table->decimal('uniform_daily_wage', 10, 2)->nullable()->after('use_uniform_wage')->comment('Fixed daily wage for all workers under this contractor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('labor_costs', function (Blueprint $table) {
            $table->dropColumn(['use_uniform_wage', 'uniform_daily_wage']);
        });
    }
};
