<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Freelancer;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Registro fixo
        User::factory()->create([
            'id' => 1,
            'cpf_cnpj' => '12.345.678/0001-00',
            'name' => 'Test User',
            'email' => 'leonardolucas181204@gmail.com',
            'phone' => '11997385214',
            'password' => Hash::make('123'),
            'usertype' => '3',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Vários registros aleatórios
        User::factory(1)->create();
        Employee::factory(10)->create();
        Vehicle::factory(10)->create();
        Freelancer::factory(10)->create();
    }
}
