<?php

use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user1 = User::factory()->create(['email' => 'user1@example.com']);
    $this->user2 = User::factory()->create(['email' => 'user2@example.com']);
    $this->user3 = User::factory()->create(['email' => 'user3@example.com']);
    $this->user4 = User::factory()->create(['email' => 'user4@example.com']);

    $this->ingredient1 = Ingredient::factory()->create(['name' => 'Ingredient One']);
    $this->ingredient2 = Ingredient::factory()->create(['name' => 'Ingredient Two']);
    $this->ingredient3 = Ingredient::factory()->create(['name' => 'Ingredient Three']);

    $this->recipe1 = Recipe::factory()->create([
        'user_id' => $this->user1->id,
        'title' => 'Test Recipe One',
        'description' => 'Test recipe description one',
    ]);
    $this->recipe1->ingredients()->attach($this->ingredient1, ['quantity' => 1, 'unit' => 'g']);

    $this->recipe2 = Recipe::factory()->create([
        'user_id' => $this->user2->id,
        'title' => 'Test Recipe Two',
        'description' => 'Test recipe description two',
    ]);
    $this->recipe2->ingredients()->attach($this->ingredient2, ['quantity' => 1, 'unit' => 'g']);

    $this->recipe3 = Recipe::factory()->create([
        'user_id' => $this->user1->id,
        'title' => 'Test Recipe Three',
        'description' => 'Test recipe description three',
    ]);
    $this->recipe3->ingredients()->attach($this->ingredient1, ['quantity' => 1, 'unit' => 'g']);

    $this->recipe4 = Recipe::factory()->create([
        'user_id' => $this->user3->id,
        'title' => 'Test Recipe Four',
        'description' => 'Test recipe description four',
    ]);
    $this->recipe4->ingredients()->attach($this->ingredient3, ['quantity' => 1, 'unit' => 'g']);
});

dataset('filter_combinations', [
    'no filters' => [[], 4, ['Test Recipe One', 'Test Recipe Two', 'Test Recipe Three', 'Test Recipe Four']],
    'keyword One' => [['keyword' => 'One'], 2, ['Test Recipe One', 'Test Recipe Three']],
    'ingredient Ingredient One' => [['ingredient' => 'Ingredient One'], 2, ['Test Recipe One', 'Test Recipe Three']],
    'email user1@example.com' => [['email' => 'user1@example.com'], 2, ['Test Recipe One', 'Test Recipe Three']],
    'keyword One and ingredient Ingredient One' => [['keyword' => 'One', 'ingredient' => 'Ingredient One'], 2, ['Test Recipe One', 'Test Recipe Three']],
    'keyword Two and email user2@example.com' => [['keyword' => 'Two', 'email' => 'user2@example.com'], 1, ['Test Recipe Two']],
    'ingredient Ingredient One and email user1@example.com' => [['ingredient' => 'Ingredient One', 'email' => 'user1@example.com'], 2, ['Test Recipe One', 'Test Recipe Three']],
    'all three filters: keyword One, ingredient Ingredient One, email user1@example.com' => [['keyword' => 'One', 'ingredient' => 'Ingredient One', 'email' => 'user1@example.com'], 2, ['Test Recipe One', 'Test Recipe Three']],
    'filters with no results: keyword Nonexistent' => [['keyword' => 'Nonexistent'], 0, []],
    'filters with no results: ingredient Nonexistent' => [['ingredient' => 'Nonexistent'], 0, []],
    'filters with no results: email user4@example.com' => [['email' => 'user4@example.com'], 0, []],
    'combined filters with no results: keyword One and ingredient Ingredient Two' => [['keyword' => 'One', 'ingredient' => 'Ingredient Two'], 0, []],
]);

test('it can filter recipes with all combinations', function ($filters, $expectedCount, $expectedTitles) {
    $query = http_build_query($filters);
    $response = $this->getJson("/api/recipes?{$query}");

    expect($response->status())->toBe(200)
        ->and($response->json('error'))->toBeFalse()
        ->and($response->json('data.recipes'))->toHaveCount($expectedCount);

    if ($expectedCount > 0) {
        $titles = collect($response->json('data.recipes'))->pluck('title')->toArray();
        expect($titles)->toContain(...$expectedTitles);
    }
})->with('filter_combinations');

test('it can show a single recipe with related data', function () {
    $response = $this->getJson("/api/recipes/{$this->recipe1->slug}");

    expect($response->json())
        ->toHaveKey('data')
        ->and($response->json('error'))->toBeFalse()
        ->and($response->json('data'))
        ->toHaveKeys(['id', 'title', 'description', 'slug', 'ingredients', 'steps', 'user'])
        ->and($response->json('data.title'))
        ->toBe('Test Recipe One');
});

test('it returns 404 for non-existent recipe', function () {
    $response = $this->getJson('/api/recipes/nonexistent-recipe');

    expect($response->status())->toBe(404);
});
