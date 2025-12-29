<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = ['present', 'absent', 'leave', 'half_day', 'holiday', 'overtime'];
        $status = fake()->randomElement($statuses);

        // Calculate wage based on status (will be updated by model boot method)
        $wageAmount = match($status) {
            'present' => fake()->randomFloat(2, 300, 1500),
            'half_day' => fake()->randomFloat(2, 150, 750),
            'overtime' => fake()->randomFloat(2, 450, 2250),
            'absent', 'leave', 'holiday' => 0,
            default => fake()->randomFloat(2, 300, 1500),
        };

        return [
            'project_id' => \App\Models\Project::factory(),
            'worker_id' => \App\Models\Worker::factory(),
            'labor_cost_id' => fake()->boolean(30) ? \App\Models\LaborCost::factory() : null,
            'attendance_date' => fake()->dateTimeBetween('-30 days', 'now'),
            'status' => $status,
            'hours_worked' => fake()->boolean(60) ? fake()->randomFloat(1, 4, 12) : null,
            'work_description' => fake()->boolean(50) ? fake()->sentence() : null,
            'notes' => fake()->boolean(40) ? fake()->sentence() : null,
            'wage_amount' => $wageAmount,
        ];
    }
}
