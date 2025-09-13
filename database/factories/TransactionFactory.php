<?php

namespace Database\Factories;
use App\Models\User;
use App\Models\Category;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    public function definition(): array
    {
        $types = ['income', 'expense'];
        $type = $this->faker->randomElement($types);

        return [
            'description' => $this->faker->sentence(3),
            'amount' => $this->faker->randomFloat(2, 1, 1000),
            'date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'type' => $type,
            'category_id' => Category::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'notes' => $this->faker->sentence(),
        ];
    }
}
