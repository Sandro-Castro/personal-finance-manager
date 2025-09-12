<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    
    public function run(): void
    {
       Category::create([
            'name' => 'Salário',
            'type' => 'income',
            'color' => '#10B981',
            'icon' => '💰',
            'description' => 'Salário mensal'
        ]);
        
        Category::create([
            'name' => 'Freelance',
            'type' => 'income',
            'color' => '#10B981',
            'icon' => '💻',
            'description' => 'Trabalhos freelancer'
        ]);
        Category::create([
            'name' => 'Alimentação',
            'type' => 'expense',
            'color' => '#EF4444',
            'icon' => '🍔',
            'description' => 'Gastos com alimentação'
        ]);
        
        Category::create([
            'name' => 'Transporte',
            'type' => 'expense',
            'color' => '#EF4444',
            'icon' => '🚗',
            'description' => 'Gastos com transporte'
        ]);
        Category::create([
            'name' => 'Moradia',
            'type' => 'expense',
            'color' => '#EF4444',
            'icon' => '🏠',
            'description' => 'Gastos com moradia'
        ]);
        

        Category::factory()->count(5)->create();
    }
}
