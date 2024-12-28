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
            'company_id' => User::inRandomOrder()->first()->id,
            'company_cpfcnpj' => User::inRandomOrder()->first()->cpf_cnpj,
            'status' => fake()->randomElement(['Fatura aberta', 'Aguardando pagamento', 'Fatura pendente', 'Fatura paga']),
            'cost_employee' => fake()->randomDigit(1, 10),
            'cost_freelancer' => fake()->randomDigit(1, 10),
            'cost_vehicle' => fake()->randomDigit(1, 10),
            'price' => fn (array $attributes) => $attributes['cost_employee'] + $attributes['cost_freelancer'] + $attributes['cost_vehicle'],
            'price_updated' => fake()->randomElement([true, false])
        ];
    }
}
