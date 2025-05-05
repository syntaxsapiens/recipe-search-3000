<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IngredientRecipeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'quantity' => $this->pivot->quantity,
            'unit' => $this->pivot->unit,
            'name' => $this->name,
        ];
    }
}
