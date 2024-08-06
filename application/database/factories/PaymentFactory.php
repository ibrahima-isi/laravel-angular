<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
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
        return [
            'order_id' => \App\Models\Order::factory(),
            'amount' => $this->faker->randomFloat(2, 1, 1000),
            'payment_method' => $this->faker->randomElement(['cash', 'card', 'orange_money', 'wave']),
            'payment_status' => $this->faker->randomElement(['pending', 'completed', 'cancelled']),
            'payment_date' => $this->faker->dateTimeThisYear(),
        ];
    }
}
