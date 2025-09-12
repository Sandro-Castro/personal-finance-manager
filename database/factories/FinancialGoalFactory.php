<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FinancialGoal>
 */
class FinancialGoalFactory extends Factory
{
    
    public function definition(): array
    {
        $statuses = ['in_progress', 'completed', 'cancelled'];
        

        return [
            'name' => $this->faker->sentence(2),
            'target_amount' => $this->faker->randomFloat(2, 100, 10000),
            'current_amount' => $this->faker->randomFloat(2, 0, 5000),
            'deadline' => $this->faker->dateTimeBetween('now', '+2 years'),
            'status' => $this->faker->randomElement($statuses),
            'description' => $this->faker->paragraph(),
            'user_id' => User::factory()
        ];
    }
}
