<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Worker>
 */
class WorkerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $laborTypes = ['daily', 'skilled', 'unskilled', 'specialist'];
        $categories = ['mason', 'carpenter', 'electrician', 'plumber', 'painter', 'welder', 'helper', 'other'];

        return [
            'project_id' => \App\Models\Project::factory(),
            'labor_cost_id' => fake()->boolean(30) ? \App\Models\LaborCost::factory() : null,
            'primary_contractor_id' => fake()->boolean(40) ? \App\Models\LaborCost::factory() : null,
            'name' => fake()->firstName() . ' ' . fake()->lastName(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->boolean(50) ? fake()->email() : null,
            'address' => fake()->boolean(40) ? fake()->address() : null,
            'labor_type' => fake()->randomElement($laborTypes),
            'category' => fake()->randomElement($categories),
            'daily_wage' => fake()->randomFloat(2, 300, 1500),
            'is_active' => fake()->boolean(90), // 90% active
            'hire_date' => fake()->dateTimeBetween('-6 months', 'now'),
            'terminate_date' => fake()->boolean(10) ? fake()->dateTimeBetween('-3 months', 'now') : null,
            'notes' => fake()->boolean(30) ? fake()->sentence() : null,
        ];
    }
}
