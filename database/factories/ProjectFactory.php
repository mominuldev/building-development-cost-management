<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $projectTypes = [
            'Residential House Construction',
            'Commercial Building',
            'Office Complex',
            'Shopping Mall',
            'Apartment Complex',
            'Villa Construction',
            'School Building',
            'Hospital Construction',
            'Warehouse',
            'Restaurant Building'
        ];

        $locations = [
            'Downtown', 'Suburban Area', 'Industrial Zone', 'Commercial District',
            'Residential Area', 'Business Park', 'City Center', 'Outskirts'
        ];

        $statuses = ['planning', 'in_progress', 'completed', 'on_hold'];

        return [
            'user_id' => 1,
            'name' => fake()->randomElement($projectTypes) . ' - ' . fake()->streetAddress(),
            'location' => fake()->randomElement($locations) . ', ' . fake()->city(),
            'estimated_budget' => fake()->randomFloat(2, 50000, 5000000),
            'start_date' => fake()->dateTimeBetween('-1 year', 'now'),
            'end_date' => fake()->dateTimeBetween('now', '+2 years'),
            'status' => fake()->randomElement($statuses),
            'notes' => fake()->optional()->paragraph(),
        ];
    }
}
