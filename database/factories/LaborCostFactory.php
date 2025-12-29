<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LaborCost>
 */
class LaborCostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'mason', 'carpenter', 'electrician', 'plumber',
            'painter', 'welder', 'helper', 'other'
        ];

        return [
            'project_id' => \App\Models\Project::factory(),
            'labor_type' => 'contractor',
            'name' => fake()->firstName() . ' ' . fake()->lastName() . ' & Sons Contracting',
            'category' => fake()->randomElement($categories),
            'number_of_workers' => null, // Not used for contractors anymore
            'daily_wage' => null, // Not used for contractors anymore
            'days_worked' => null, // Not used for contractors anymore
            'total_cost' => 0, // Will be calculated from assigned workers
            'work_date' => fake()->dateTimeBetween('-3 months', 'now'),
            'description' => fake()->sentence(),
            'notes' => fake()->optional(50)->paragraph(),
            'is_attendance_based' => true, // Contractors always use attendance-based calculation
            'calculated_total' => fake()->optional()->randomFloat(2, 10000, 500000), // Calculated from workers
        ];
    }
}
