<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Organization;
use App\Models\User;
use App\Models\Category;

class BudgetCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_update_and_delete_budget()
    {
        $org = Organization::create(['name' => 'Org B']);
        $user = User::factory()->create(['organization_id' => $org->id]);
        $this->actingAs($user);

        $cat = Category::create(['name' => 'Moradia', 'type' => 'expense', 'organization_id' => $org->id]);

        $response = $this->post(route('budgets.store'), [
            'name' => 'Teste Orçamento',
            'amount' => 1000.00,
            'start_date' => now()->startOfMonth()->format('Y-m-d'),
            'end_date' => now()->endOfMonth()->format('Y-m-d'),
            'category_id' => $cat->id,
            'is_active' => 1,
        ]);

        $response->assertRedirect(route('budgets.index'));
        $this->assertDatabaseHas('budgets', ['name' => 'Teste Orçamento', 'organization_id' => $org->id]);

        $budget = \App\Models\Budget::where('organization_id', $org->id)->first();

        $response = $this->put(route('budgets.update', $budget), [
            'name' => 'Teste Orçamento 2',
            'amount' => 1500.00,
            'start_date' => now()->startOfMonth()->format('Y-m-d'),
            'end_date' => now()->endOfMonth()->format('Y-m-d'),
            'category_id' => $cat->id,
            'is_active' => 1,
        ]);

        $response->assertRedirect(route('budgets.index'));
        $this->assertDatabaseHas('budgets', ['id' => $budget->id, 'name' => 'Teste Orçamento 2']);

        $response = $this->delete(route('budgets.destroy', $budget));
        $response->assertRedirect(route('budgets.index'));
        $this->assertDatabaseMissing('budgets', ['id' => $budget->id]);
    }
}
