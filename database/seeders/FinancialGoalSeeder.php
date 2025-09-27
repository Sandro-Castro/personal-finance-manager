<?php

namespace Database\Seeders;

use App\Models\FinancialGoal;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
class FinancialGoalSeeder extends Seeder
{
    
    public function run(): void
    {
        $users = User::all();
        foreach ($users as $user) {
        $categories = Category::where('user_id', $user->id)->get();
        
        FinancialGoal::create([
            'name' => 'Comprar um novo laptop',
            'target_amount' => 5000.00,
            'current_amount' => 2500.00,
            'deadline' => now()->addMonths(6),
            'status' => 'in_progress',
            'description' => 'Economizar para comprar um laptop para programação',
            'user_id' => $user->id,
            'category_id' => $categories->where('name', 'Salário')->first()->id ?? null,
        ]);

        FinancialGoal::create([
            'name' => 'Viagem de férias',
            'target_amount' => 3000.00,
            'current_amount' => 1000.00,
            'deadline' => now()->addYear(),
            'status' => 'in_progress',
            'description' => 'Economizar para uma viagem nas férias',
            'user_id' => $user->id,
            'category_id' => $categories->where('name', 'Freelance')->first()->id ?? null,
        ]);

        FinancialGoal::create([
            'name' => 'Reserva de emergência',
            'target_amount' => 10000.00,
            'current_amount' => 7000.00,
            'deadline' => now()->addMonths(18),
            'status' => 'in_progress',
            'description' => 'Criar uma reserva de emergência',
            'user_id' => $user->id,
            'category_id' => $categories->where('name', 'Alimentação')->first()->id ?? null,
        ]);
        FinancialGoal::factory()->count(5)->create([
            'user_id' => $user->id
        ]);  
    } 
    }
}
