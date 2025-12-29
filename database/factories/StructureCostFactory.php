<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StructureCost>
 */
class StructureCostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = [
            'foundation' => ['Concrete Foundation', 'Pile Foundation', 'Raft Foundation', 'Strip Foundation'],
            'columns' => ['RCC Columns', 'Steel Columns', 'Brick Columns', 'Wooden Columns'],
            'beams' => ['RCC Beams', 'Steel Beams', 'Wooden Beams'],
            'slabs' => ['RCC Slab', 'Pre-stressed Slab', 'Flat Slab'],
            'roof' => ['Flat Roof', 'Pitched Roof', 'Domed Roof', 'Skylight Roof'],
            'walls' => ['Brick Walls', 'Concrete Walls', 'Dry Walls'],
            'other' => ['Elevator Shaft', 'Water Tank', 'Septic Tank', 'Parking Structure']
        ];

        $structureType = fake()->randomElement(array_keys($types));
        $name = fake()->randomElement($types[$structureType]);

        $quantity = fake()->randomFloat(2, 10, 1000);
        $unitPrice = fake()->randomFloat(2, 50, 500);

        return [
            'project_id' => \App\Models\Project::factory(),
            'structure_type' => $structureType,
            'name' => $name,
            'description' => fake()->sentence(),
            'quantity' => $quantity,
            'unit' => fake()->randomElement(['sq ft', 'sq meter', 'cubic meter', 'linear ft', 'tons', 'pieces']),
            'unit_price' => $unitPrice,
            'total_cost' => $quantity * $unitPrice,
            'work_date' => fake()->dateTimeBetween('-2 months', 'now'),
            'notes' => fake()->optional()->paragraph(),
        ];
    }
}
