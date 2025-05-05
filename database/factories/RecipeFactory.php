<?php

namespace Database\Factories;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(3),
            'user_id' => User::inRandomOrder()->first()->id,
            'image' => 'https://picsum.photos/id/'.rand(1, 100).'/400/400',
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Recipe $recipe) {
            $stepCount = rand(2, 8);
            for ($i = 1; $i <= $stepCount; $i++) {
                $recipe->steps()->create([
                    'order' => $i,
                    'instruction' => fake()->sentence(10),
                ]);
            }
        });
    }
}
