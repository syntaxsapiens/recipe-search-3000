<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    public function run(): void
    {
        $ingredients = ['salt', 'black pepper', 'white pepper', 'olive oil', 'canola oil', 'vegetable oil', 'butter', 'margarine', 'garlic', 'onion', 'shallot', 'green onion', 'leek', 'chive', 'ginger', 'lemongrass', 'basil', 'oregano', 'thyme', 'rosemary', 'parsley', 'cilantro', 'dill', 'mint', 'bay leaf', 'sage', 'tarragon', 'cumin', 'coriander', 'paprika', 'smoked paprika', 'chili powder', 'cayenne pepper', 'turmeric', 'curry powder', 'garam masala', 'allspice', 'nutmeg', 'cinnamon', 'clove', 'cardamom', 'mustard seeds', 'fennel seeds', 'anise seeds', 'sugar', 'brown sugar', 'honey', 'maple syrup', 'molasses', 'vinegar', 'apple cider vinegar', 'balsamic vinegar', 'white vinegar', 'soy sauce', 'fish sauce', 'oyster sauce', 'Worcestershire sauce', 'ketchup', 'mayonnaise', 'mustard', 'hot sauce', 'sriracha', 'tomato paste', 'tomato sauce', 'crushed tomatoes', 'diced tomatoes', 'whole tomatoes', 'flour', 'cornstarch', 'baking powder', 'baking soda', 'yeast', 'eggs', 'milk', 'cream', 'sour cream', 'yogurt', 'cheddar cheese', 'parmesan cheese', 'mozzarella', 'feta cheese', 'cream cheese', 'cottage cheese', 'chicken breast', 'chicken thighs', 'ground beef', 'steak', 'pork chops', 'bacon', 'sausage', 'ham', 'turkey', 'salmon', 'tuna', 'shrimp', 'crab', 'lobster', 'rice', 'pasta', 'quinoa', 'lentils', 'chickpeas', 'black beans', 'kidney beans'];

        foreach ($ingredients as $ingredient) {
            Ingredient::create([
                'name' => $ingredient,
            ]);
        }
    }
}
