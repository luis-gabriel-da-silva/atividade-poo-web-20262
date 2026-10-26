<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement([
            'pago',
            'cancelado',
            'aberto'
        ]);

        return [
            'custumer_id' => Customer::factory(),
            'total_price' => fake()->randomFloat(2, 10, 1000),
            'status' => $status,
            'paid_at' => $status === 'pago'
                ? fake()->dateTimeBetween('-1 year', 'now')
                : null,
        ];
    }
}
