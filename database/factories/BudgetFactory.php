<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\Budget\Infrastructure\Persistence\Eloquent\BudgetModel as Budget;
use App\Modules\Organization\Infrastructure\Persistence\Eloquent\OrganizationModel as Organization;
use App\Modules\Admin\Infrastructure\Persistence\Eloquent\CategoryModel as Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Modules\Budget\Infrastructure\Persistence\Eloquent\BudgetModel>
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
