<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name, // Gera um nome fictício
            'rg' => $this->faker->numerify('##.###.###-#'), // Gera um RG fictício no formato XX.XXX.XXX-X
            'cpf' => $this->faker->numerify('###.###.###-##'), // Gera um CPF fictício no formato XXX.XXX.XXX-XX
            'nascimento' => $this->faker->date(), // Gera uma data de nascimento fictícia
            'pai' => $this->faker->name, // Gera o nome do pai fictício
            'mae' => $this->faker->name, // Gera o nome da mãe fictício
            'user_id' => User::inRandomOrder()->first()->id, // Associa um usuário existente aleatoriamente
            'return_status' => fake()->randomElement(['Em análise', 'Aprovado', 'Rejeitado']), // Status aleatório
        ];
    }
}
