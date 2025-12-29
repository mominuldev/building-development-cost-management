<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FinishingWork>
 */
class FinishingWorkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $workTypes = [
            'flooring' => ['Marble Flooring', 'Tile Flooring', 'Hardwood Floor', 'Carpet', 'Vinyl Flooring', 'Polished Concrete'],
            'painting' => ['Interior Painting', 'Exterior Painting', 'Wall Texture', 'Wallpaper Installation', 'Wood Staining'],
            'plumbing' => ['Bathroom Fixtures', 'Kitchen Plumbing', 'Pipe Installation', 'Drainage System', 'Water Heater'],
            'electrical' => ['Wiring', 'Lighting Fixtures', 'Switch Boards', 'Power Outlets', 'Security Systems'],
            'carpentry' => ['Door Installation', 'Window Frames', 'Kitchen Cabinets', 'Wardrobes', 'Shelving'],
            'hvac' => ['Air Conditioning', 'Ventilation', 'Heating System', 'Duct Work'],
            'other' => ['Landscaping', 'Fencing', 'Swimming Pool', 'Solar Panels']
        ];

        $workType = fake()->randomElement(array_keys($workTypes));
        $name = fake()->randomElement($workTypes[$workType]);

        $quantity = fake()->randomFloat(2, 5, 500);
        $unitPrice = fake()->randomFloat(2, 20, 300);

        return [
            'project_id' => \App\Models\Project::factory(),
            'work_type' => $workType,
            'name' => $name,
            'description' => fake()->sentence(),
            'quantity' => $quantity,
            'unit' => fake()->randomElement(['sq ft', 'sq meter', 'room', 'piece', 'set', 'linear ft']),
            'unit_price' => $unitPrice,
            'total_cost' => $quantity * $unitPrice,
            'work_date' => fake()->dateTimeBetween('-1 month', 'now'),
            'notes' => fake()->optional()->paragraph(),
        ];
    }
}
