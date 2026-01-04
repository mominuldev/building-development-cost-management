<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create contractor_costs table with all columns from labor_costs
        Schema::create('contractor_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->enum('labor_type', ['daily', 'contractor', 'skilled', 'unskilled', 'specialist']);
            $table->string('name')->nullable();
            $table->string('category')->nullable()->comment('mason, carpenter, electrician, plumber, etc.');
            $table->integer('number_of_workers')->nullable();
            $table->decimal('daily_wage', 10, 2)->nullable();
            $table->integer('days_worked')->nullable();
            $table->decimal('total_cost', 15, 2);
            $table->decimal('calculated_total', 15, 2)->nullable()->comment('Recalculated from attendance');
            $table->date('work_date')->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_attendance_based')->default(false);
            $table->boolean('use_uniform_wage')->default(false)->comment('Use same daily wage for all workers');
            $table->decimal('uniform_daily_wage', 10, 2)->nullable()->comment('Fixed daily wage for all workers under this contractor');
            $table->timestamps();
        });

        // Copy data from labor_costs to contractor_costs
        DB::statement('INSERT INTO contractor_costs SELECT * FROM labor_costs');

        // Drop foreign key constraints first (use try-catch to handle cases where they don't exist)
        try {
            if (Schema::hasTable('attendances')) {
                Schema::table('attendances', function (Blueprint $table) {
                    $table->dropForeign(['labor_cost_id']);
                });
            }
        } catch (\Exception $e) {
            // Foreign key doesn't exist, continue
        }

        try {
            if (Schema::hasTable('workers')) {
                Schema::table('workers', function (Blueprint $table) {
                    $table->dropForeign(['labor_cost_id']);
                });
            }
        } catch (\Exception $e) {
            // Foreign key doesn't exist, continue
        }

        try {
            if (Schema::hasTable('contractor_worker')) {
                Schema::table('contractor_worker', function (Blueprint $table) {
                    $table->dropForeign(['contractor_id']);
                });
            }
        } catch (\Exception $e) {
            // Foreign key doesn't exist, continue
        }

        // Drop the old labor_costs table
        Schema::dropIfExists('labor_costs');

        // Recreate foreign key constraints pointing to contractor_costs
        if (Schema::hasTable('attendances')) {
            Schema::table('attendances', function (Blueprint $table) {
                $table->foreign('labor_cost_id')->references('id')->on('contractor_costs')->onDelete('cascade');
            });
        }

        if (Schema::hasTable('workers')) {
            Schema::table('workers', function (Blueprint $table) {
                $table->foreign('labor_cost_id')->references('id')->on('contractor_costs')->onDelete('cascade');
            });
        }

        if (Schema::hasTable('contractor_worker')) {
            Schema::table('contractor_worker', function (Blueprint $table) {
                $table->foreign('contractor_id')->references('id')->on('contractor_costs')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign key constraints first (use try-catch to handle cases where they don't exist)
        try {
            if (Schema::hasTable('attendances')) {
                Schema::table('attendances', function (Blueprint $table) {
                    $table->dropForeign(['labor_cost_id']);
                });
            }
        } catch (\Exception $e) {
            // Foreign key doesn't exist, continue
        }

        try {
            if (Schema::hasTable('workers')) {
                Schema::table('workers', function (Blueprint $table) {
                    $table->dropForeign(['labor_cost_id']);
                });
            }
        } catch (\Exception $e) {
            // Foreign key doesn't exist, continue
        }

        try {
            if (Schema::hasTable('contractor_worker')) {
                Schema::table('contractor_worker', function (Blueprint $table) {
                    $table->dropForeign(['contractor_id']);
                });
            }
        } catch (\Exception $e) {
            // Foreign key doesn't exist, continue
        }

        // Recreate labor_costs table
        Schema::create('labor_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->enum('labor_type', ['daily', 'contractor', 'skilled', 'unskilled', 'specialist']);
            $table->string('name')->nullable();
            $table->string('category')->nullable()->comment('mason, carpenter, electrician, plumber, etc.');
            $table->integer('number_of_workers')->nullable();
            $table->decimal('daily_wage', 10, 2)->nullable();
            $table->integer('days_worked')->nullable();
            $table->decimal('total_cost', 15, 2);
            $table->decimal('calculated_total', 15, 2)->nullable()->comment('Recalculated from attendance');
            $table->date('work_date')->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_attendance_based')->default(false);
            $table->boolean('use_uniform_wage')->default(false)->comment('Use same daily wage for all workers');
            $table->decimal('uniform_daily_wage', 10, 2)->nullable()->comment('Fixed daily wage for all workers under this contractor');
            $table->timestamps();
        });

        // Copy data back from contractor_costs to labor_costs
        DB::statement('INSERT INTO labor_costs SELECT * FROM contractor_costs');

        // Drop contractor_costs table
        Schema::dropIfExists('contractor_costs');

        // Recreate foreign key constraints pointing to labor_costs
        if (Schema::hasTable('attendances')) {
            Schema::table('attendances', function (Blueprint $table) {
                $table->foreign('labor_cost_id')->references('id')->on('labor_costs')->onDelete('cascade');
            });
        }

        if (Schema::hasTable('workers')) {
            Schema::table('workers', function (Blueprint $table) {
                $table->foreign('labor_cost_id')->references('id')->on('labor_costs')->onDelete('cascade');
            });
        }

        if (Schema::hasTable('contractor_worker')) {
            Schema::table('contractor_worker', function (Blueprint $table) {
                $table->foreign('contractor_id')->references('id')->on('labor_costs')->onDelete('cascade');
            });
        }
    }
};
