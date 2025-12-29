<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $recipientType = fake()->randomElement(['contractor', 'worker']);

        return [
            'project_id' => \App\Models\Project::factory(),
            'recipient_type' => $recipientType,
            'recipient_id' => $recipientType === 'contractor'
                ? \App\Models\LaborCost::factory()
                : \App\Models\Worker::factory(),
            'amount' => fake()->randomFloat(2, 1000, 100000),
            'payment_date' => fake()->dateTimeBetween('-60 days', 'now'),
            'payment_method' => fake()->randomElement(['cash', 'bank_transfer', 'check', 'upi', 'other']),
            'transaction_reference' => fake()->optional()->numerify('TXN-########'),
            'status' => fake()->randomElement(['paid', 'partial', 'pending', 'cancelled']),
            'notes' => fake()->optional()->sentence(),
            'period_start' => fake()->optional()->dateTimeBetween('-90 days', '-30 days'),
            'period_end' => fake()->optional()->dateTimeBetween('-30 days', 'now'),
        ];
    }
}
