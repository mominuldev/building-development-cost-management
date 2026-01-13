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
        // Add foreign keys to workers table
        Schema::table('workers', function (Blueprint $table) {
            $table->foreign('labor_cost_id')->references('id')->on('contractor_costs')->onDelete('cascade');
            $table->foreign('primary_contractor_id')->references('id')->on('contractor_costs')->nullOnDelete();
        });

        // Add foreign key to attendances table
        Schema::table('attendances', function (Blueprint $table) {
            $table->foreign('labor_cost_id')->references('id')->on('contractor_costs')->onDelete('cascade');
        });

        // Add foreign key to contractor_worker table
        Schema::table('contractor_worker', function (Blueprint $table) {
            $table->foreign('contractor_id')->references('id')->on('contractor_costs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign keys from workers table
        Schema::table('workers', function (Blueprint $table) {
            $table->dropForeign(['labor_cost_id']);
            $table->dropForeign(['primary_contractor_id']);
        });

        // Drop foreign key from attendances table
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropForeign(['labor_cost_id']);
        });

        // Drop foreign key from contractor_worker table
        Schema::table('contractor_worker', function (Blueprint $table) {
            $table->dropForeign(['contractor_id']);
        });
    }
};
