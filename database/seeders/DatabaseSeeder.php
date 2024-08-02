<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // User::factory(10)->create();
        
        User::factory()->create([
            'id' => 1,
            'name' => 'Test User',
            'email' => 'leonardolucas181204@gmail.com',
            'password' => Hash::make('123'), // Senha deve ser criptografada
            'usertype' => '3',
            'email_verified_at' => now(), // Data atual para email verificado
            'created_at' => now(), // Data atual
            'updated_at' => now(), // Data atual
        ]);
    }
}
