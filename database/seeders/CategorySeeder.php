<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    
    public function run(): void
    {
        $users = User::all();
        
        foreach ($users as $user) {

            Category::create([
            'name' => 'Salário',
            'type' => 'income',
            'color' => '#10B981',
            'icon' => '💰',
            'description' => 'Salário mensal',
            'user_id' => $user->id
            
        ]);
        
        Category::create([
            'name' => 'Freelance',
            'type' => 'income',
            'color' => '#10B981',
            'icon' => '💻',
            'description' => 'Trabalhos freelancer',
            'user_id' => $user->id
             
        ]);
        Category::create([
            'name' => 'Alimentação',
            'type' => 'expense',
            'color' => '#EF4444',
            'icon' => '🍔',
            'description' => 'Gastos com alimentação',
            'user_id' => $user->id
        ]);
        
        Category::create([
            'name' => 'Transporte',
            'type' => 'expense',
            'color' => '#EF4444',
            'icon' => '🚗',
            'description' => 'Gastos com transporte',
            'user_id' => $user->id
        ]);
        Category::create([
            'name' => 'Moradia',
            'type' => 'expense',
            'color' => '#EF4444',
            'icon' => '🏠',
            'description' => 'Gastos com moradia',
            'user_id' => $user->id
        ]);
            Category::factory()->count(2)->create([
                'user_id' => $user->id
            ]);
        }
    }
}
