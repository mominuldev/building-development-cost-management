<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Material>
 */
class MaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $materialTypes = [
            'bricks', 'brick_chips', 'cement', 'steel', 'sand', 'stone', 'other'
        ];

        $materials = [
            ['cement', 'Cement', 'bag', 8, 12],
            ['steel', 'Steel Rods', 'ton', 500, 800],
            ['sand', 'Sand', 'cubic meter', 30, 60],
            ['stone', 'Gravel', 'cubic meter', 35, 65],
            ['bricks', 'Red Bricks', 'thousand', 300, 500],
            ['brick_chips', 'Brick Chips', 'cubic meter', 25, 45],
            ['other', 'Timber', 'cubic foot', 15, 25],
            ['other', 'Paint', 'gallon', 25, 80],
            ['other', 'Tiles', 'square meter', 5, 50],
            ['other', 'Glass', 'square meter', 20, 100],
            ['other', 'PVC Pipes', 'meter', 2, 15],
            ['other', 'Electrical Wire', 'meter', 1, 10],
            ['other', 'Roofing Sheets', 'piece', 20, 100],
            ['other', 'Nails', 'kg', 3, 8],
        ];

        $material = fake()->randomElement($materials);
        $quantity = fake()->randomFloat(2, 10, 1000);
        $unitPrice = fake()->randomFloat(2, $material[3], $material[4]);

        return [
            'project_id' => \App\Models\Project::factory(),
            'material_type' => $material[0],
            'name' => $material[1],
            'supplier' => fake()->optional()->company(),
            'quantity' => $quantity,
            'unit' => $material[2],
            'unit_price' => $unitPrice,
            'total_cost' => $quantity * $unitPrice,
            'purchase_date' => fake()->dateTimeBetween('-6 months', 'now'),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
