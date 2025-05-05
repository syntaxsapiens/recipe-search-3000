<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class IndexRecipeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ingredient' => ['string', 'nullable'],
            'keyword' => ['string', 'nullable'],
            'email' => ['email', 'exists:users,email', 'nullable'],
            'page' => ['integer', 'nullable'],
        ];
    }
}
