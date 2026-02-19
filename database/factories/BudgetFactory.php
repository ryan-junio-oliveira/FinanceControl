<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Budget;
use App\Models\Organization;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Budget>
 */
class BudgetFactory extends Factory
{
    protected $model = Budget::class;

    public function definition(): array
    {
        $start = now()->subMonths(fake()->numberBetween(0, 6));
        $end = (clone $start)->addMonths(fake()->numberBetween(1, 6));

        return [
            'name' => fake()->words(2, true),
            'amount' => fake()->randomFloat(2, 100, 5000),
            'start_date' => $start->toDateString(),
            'end_date' => $end->toDateString(),
            'category_id' => Category::factory(),
            'is_active' => true,
            'organization_id' => Organization::factory(),
        ];
    }
}
