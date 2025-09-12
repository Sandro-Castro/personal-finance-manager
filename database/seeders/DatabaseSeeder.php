<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    
    public function run(): void
    {
        $user = User::factory()->create([
            "name"=> "Sandrinho",
            "email"=> "SandrinhoTeste@gmail.com",
            "password"=> bcrypt("1234"),
        ]);

        $user2 = User::factory()->create([
            "name"=> "Rafael",
            "email"=> "RafaelTeste@gmail.com",
            "password"=> bcrypt("1234"),
        ]);

       $this->call([
        CategorySeeder::class,
        TransactionSeeder::class,   
        FinancialGoalSeeder::class,
       ]);
    }
}
