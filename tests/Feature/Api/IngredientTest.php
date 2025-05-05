<?php

use App\Models\Ingredient;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->ingredient1 = Ingredient::factory()->create(['name' => 'Ingredient One']);
    $this->ingredient2 = Ingredient::factory()->create(['name' => 'Ingredient Two']);
    $this->ingredient3 = Ingredient::factory()->create(['name' => 'Ingredient Three']);
});

test('it can suggest partial ingredient names', function () {
    $response = $this->getJson('/api/ingredients/suggest?query=Ingredient');

    expect($response->json())
        ->toHaveKey('data')
        ->and($response->json('data'))
        ->toHaveCount(3);
});

test('it can suggest exact ingredient names', function () {
    $response = $this->getJson('/api/ingredients/suggest?query=Ingredient Two');

    expect($response->json())
        ->toHaveKey('data')
        ->and($response->json('data'))
        ->toHaveCount(1);
});
