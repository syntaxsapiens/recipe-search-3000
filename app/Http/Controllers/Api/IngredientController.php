<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SuggestIngredientRequest;
use App\Http\Resources\IngredientSuggestionResource;
use App\Models\Ingredient;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class IngredientController extends Controller
{
    use ApiResponse;

    public function suggest(SuggestIngredientRequest $request): JsonResponse
    {
        $q = $request->validated();
        $ingredients = Ingredient::suggest($q['query'])->take(10)->get();

        return $this->successResponse(IngredientSuggestionResource::collection($ingredients));
    }
}
