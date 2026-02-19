<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Expense;
use App\Models\Organization;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    protected $model = Expense::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'amount' => fake()->randomFloat(2, 1, 1000),
            'fixed' => fake()->boolean(20),
            'transaction_date' => now()->subDays(fake()->numberBetween(0, 90)),
            'monthly_financial_control_id' => null,
            'credit_card_id' => null,
            'organization_id' => Organization::factory(),
            'category_id' => Category::factory(),
        ];
    }
}
