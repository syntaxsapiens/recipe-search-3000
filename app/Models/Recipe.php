<?php

namespace App\Models;

use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Recipe extends Model
{
    use HasFactory, Slugable;

    protected $fillable = [
        'title',
        'description',
        'image',
        'user_id',
    ];

    public function scopeFilterByIngredient(Builder $query, ?string $ingredient): Builder
    {
        if (! $ingredient) {
            return $query;
        }

        return $query->whereHas('ingredients', function ($q) use ($ingredient) {
            $q->where('name', 'like', "%{$ingredient}%");
        });
    }

    public function scopeFilterByKeyword(Builder $query, ?string $keyword): Builder
    {
        if (! $keyword) {
            return $query;
        }

        return $query->where(function ($q) use ($keyword) {
            $q->where('title', 'like', "%{$keyword}%")
                ->orWhereFullText('description', $keyword)
                ->orWhereHas('steps', function ($stepQuery) use ($keyword) {
                    $stepQuery->whereFullText('instruction', $keyword);
                })
                ->orWhereHas('ingredients', function ($ingredientQuery) use ($keyword) {
                    $ingredientQuery->where('name', 'like', "%{$keyword}%");
                });
        });
    }

    public function scopeFilterByUser(Builder $query, ?string $email): Builder
    {
        if (! $email) {
            return $query;
        }

        return $query->whereHas('user', function ($userQuery) use ($email) {
            $userQuery->where('email', $email);
        });
    }

    public static function filter(array $filters = []): Builder
    {
        return static::query()
            ->filterByKeyword($filters['keyword'] ?? null)
            ->filterByIngredient($filters['ingredient'] ?? null)
            ->filterByUser($filters['email'] ?? null);
    }

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'ingredient_recipe')
            ->withPivot('quantity', 'unit');
    }

    public function steps(): HasMany
    {
        return $this->hasMany(Step::class)->orderBy('order', 'asc');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
