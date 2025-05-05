<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    public function run(): void
    {
        $ingredients = Ingredient::all();

        Recipe::factory(50)->create()->each(function ($recipe) use ($ingredients) {
            $ingredientCount = rand(2, 8);
            $randomIngredients = $ingredients->random($ingredientCount);

            foreach ($randomIngredients as $ingredient) {
                $recipe->ingredients()->attach($ingredient, [
                    'quantity' => 1,
                    'unit' => 'g',
                ]);
            }
        });
    }
}
