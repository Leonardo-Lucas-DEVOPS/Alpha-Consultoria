<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'status' => fake()->randomElement(['Pago', 'Pendente', 'Em atraso']),
            'cost_employee' => fake()->randomDigit(1, 10),
            'cost_freelancer' => fake()->randomDigit(1, 10),
            'cost_vehicle' => fake()->randomDigit(1, 10),
            'price' => fake()->randomDigit(1, 30)
        ];
    }
}
