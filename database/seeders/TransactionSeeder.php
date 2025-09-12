<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    
    public function run(): void
    {
         $categories = Category::all();
         $user = User::all();

        Transaction::create([
            'description' => 'Salário do mês',
            'amount' => 3000.00,
            'date' => now()->startOfMonth(),
            'type' => 'income',
            'category_id' => $categories->where('name', 'Salário')->first()->id,
            'user_id' => $user->id,
            'notes' => 'Salário recebido pela empresa',
        ]);

        Transaction::create([
            'description' => 'Pagamento de conta de luz',
            'amount' => 150.00,
            'date' => now()->subDays(5),
            'type' => 'expense',
            'category_id' => $categories->where('name', 'Moradia')->first()->id,
            'user_id' => $user->id,
            'notes' => 'Conta de luz do mês',
        ]);

        Transaction::create([
            'description' => 'Supermercado',
            'amount' => 350.00,
            'date' => now()->subDays(3),
            'type' => 'expense',
            'category_id' => $categories->where('name', 'Alimentação')->first()->id,
            'user_id' => $user->id,
            'notes' => 'Compra do mês no supermercado',
        ]);

        Transaction::create([
            'description' => 'Freelance projeto website',
            'amount' => 1200.00,
            'date' => now()->subDays(10),
            'type' => 'income',
            'category_id' => $categories->where('name', 'Freelance')->first()->id,
            'user_id' => $user->id,
            'notes' => 'Pagamento pelo projeto de website',
        ]);

        Transaction::factory()->count(50)->create();
    }
}
