<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\Recipe\Infrastructure\Persistence\Eloquent\RecipeModel as Recipe;
use App\Modules\Organization\Infrastructure\Persistence\Eloquent\OrganizationModel as Organization;
use App\Modules\Category\Infrastructure\Persistence\Eloquent\CategoryModel as Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Modules\Recipe\Infrastructure\Persistence\Eloquent\RecipeModel>
 */
class RecipeFactory extends Factory
{
    protected $model = Recipe::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'amount' => fake()->randomFloat(2, 1, 1000),
            'fixed' => fake()->boolean(20),
            'transaction_date' => now()->subDays(fake()->numberBetween(0, 90)),
            'organization_id' => Organization::factory(),
            'category_id' => Category::factory(),
        ];
    }
}
