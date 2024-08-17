<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'placa' => strtoupper(fake()->bothify('???-####')), // Gera uma placa no formato ABC-1234
            'chassi' => strtoupper(fake()->bothify('##?#?###########')), // Gera um chassi fictício
            'renavam' => fake()->numerify('###########'), // Gera um número RENAVAM fictício com 11 dígitos
            'user_id' => User::inRandomOrder()->first()->id, // Associa um usuário existente aleatoriamente
            'return_status' => fake()->randomElement(['Em análise', 'Aprovado', 'Reprovado']), // Status aleatório
        ];
    }   
}
