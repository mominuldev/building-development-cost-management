<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Material;
use App\Models\LaborCost;
use App\Models\StructureCost;
use App\Models\FinishingWork;
use App\Models\Worker;
use App\Models\Attendance;
use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConstructionDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding construction data...');

        // Create 10 projects
        $projects = Project::factory(10)->create();
        $this->command->info('Created 10 projects');

        // For each project, create related data
        foreach ($projects as $project) {
            $this->command->info("Seeding data for project: {$project->name}");

            // Create 10-20 materials per project
            $materials = Material::factory(fake()->numberBetween(10, 20))->create([
                'project_id' => $project->id,
            ]);

            // Create 5-10 labor costs (contractors) per project
            $laborCosts = LaborCost::factory(fake()->numberBetween(5, 10))->create([
                'project_id' => $project->id,
            ]);

            // Create 5-10 structure costs per project
            $structureCosts = StructureCost::factory(fake()->numberBetween(5, 10))->create([
                'project_id' => $project->id,
            ]);

            // Create 5-10 finishing works per project
            $finishingWorks = FinishingWork::factory(fake()->numberBetween(5, 10))->create([
                'project_id' => $project->id,
            ]);

            // Create 15-25 workers per project
            $workers = Worker::factory(fake()->numberBetween(15, 25))->create([
                'project_id' => $project->id,
                'labor_cost_id' => fake()->optional(40)->randomElement($laborCosts->pluck('id')->toArray()),
                'primary_contractor_id' => fake()->optional(50)->randomElement($laborCosts->pluck('id')->toArray()),
            ]);

            // Create 100-200 attendance records per project (without duplicates)
            $attendanceCount = fake()->numberBetween(100, 200);
            $attendanceDates = collect(range(1, 90))->map(fn($i) => now()->subDays($i)->toDateString())->unique()->take($attendanceCount);

            foreach ($attendanceDates as $date) {
                $worker = $workers->random();
                try {
                    Attendance::factory()->create([
                        'project_id' => $project->id,
                        'worker_id' => $worker->id,
                        'labor_cost_id' => fake()->optional(30)->randomElement($laborCosts->pluck('id')->toArray()),
                        'attendance_date' => $date,
                    ]);
                } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
                    // Skip duplicate attendance records
                    continue;
                }
            }

            // Create 20-30 payments per project (mix of contractor and worker payments)
            Payment::factory(fake()->numberBetween(20, 30))->create([
                'project_id' => $project->id,
                'recipient_type' => fake()->randomElement(['contractor', 'worker']),
                'recipient_id' => function (array $attributes) use ($laborCosts, $workers) {
                    return $attributes['recipient_type'] === 'contractor'
                        ? fake()->randomElement($laborCosts->pluck('id')->toArray())
                        : fake()->randomElement($workers->pluck('id')->toArray());
                },
            ]);

            $this->command->info("  - " . $materials->count() . " materials");
            $this->command->info("  - " . $laborCosts->count() . " labor costs");
            $this->command->info("  - " . $structureCosts->count() . " structure costs");
            $this->command->info("  - " . $finishingWorks->count() . " finishing works");
            $this->command->info("  - " . $workers->count() . " workers");
        }

        $this->command->info('Construction data seeding completed successfully!');
    }
}
