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
        Schema::table('workers', function (Blueprint $table) {
            $table->foreignId('primary_contractor_id')->nullable()->after('labor_cost_id')->comment('Primary contractor for this worker');
            $table->index('primary_contractor_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workers', function (Blueprint $table) {
            $table->dropForeign(['primary_contractor_id']);
            $table->dropIndex(['primary_contractor_id']);
            $table->dropColumn('primary_contractor_id');
        });
    }
};
