<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\IndexRecipeRequest;
use App\Http\Requests\Api\ShowRecipeRequest;
use App\Http\Resources\RecipeCollection;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class RecipeController extends Controller
{
    use ApiResponse;

    public function index(IndexRecipeRequest $request): JsonResponse
    {
        $filters = $request->validated();
        $recipes = Recipe::filter($filters)->paginate(12);

        return $this->successResponse(new RecipeCollection($recipes));
    }

    public function show(ShowRecipeRequest $request, Recipe $recipe): JsonResponse
    {
        $recipe->load('ingredients', 'steps', 'user');

        return $this->successResponse(new RecipeResource($recipe));
    }
}
