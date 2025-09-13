<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    
    public function definition(): array
    {
        $types = ['income', 'expense'];
        $type = $this->faker->randomElement($types);

        $incomeIcons = ['💰', '💵', '🤑', '💳'];
        $expenseIcons = ['🍔', '🏠', '🚗', '🎮'];

        return [
            'name' => $this->faker->word(),
            'type' => $type,
            'color' => $this->faker->hexColor(),
            'icon' => $type === 'income' 
                    ? $this->faker->randomElement($incomeIcons) 
                    : $this->faker->randomElement($expenseIcons),
            'description' => $this->faker->sentence(),
            'user_id' => User::inRandomOrder()->first()->id  
        ];
    }
}
