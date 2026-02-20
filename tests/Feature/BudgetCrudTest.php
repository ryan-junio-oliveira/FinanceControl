<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use App\Models\User;


class BudgetCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_update_and_delete_budget()
    {
        $orgId = DB::table('organizations')->insertGetId(['name' => 'Org B']);
        $user = User::factory()->create(['organization_id' => $orgId]);
        $this->actingAs($user);

        $catId = DB::table('categories')->insertGetId(['name' => 'Moradia', 'type' => 'expense', 'organization_id' => $orgId]);

        $response = $this->post(route('budgets.store'), [
            'name' => 'Teste Orçamento',
            'amount' => 1000.00,
            'start_date' => now()->startOfMonth()->format('Y-m-d'),
            'end_date' => now()->endOfMonth()->format('Y-m-d'),
            'category_id' => $catId,
            'is_active' => 1,
        ]);

        $response->assertRedirect(route('budgets.index'));
        $this->assertDatabaseHas('budgets', ['name' => 'Teste Orçamento', 'organization_id' => $orgId]);

        $budget = DB::table('budgets')->where('organization_id', $orgId)->first();

        $response = $this->put(route('budgets.update', ['id' => $budget->id]), [
            'name' => 'Teste Orçamento 2',
            'amount' => 1500.00,
            'start_date' => now()->startOfMonth()->format('Y-m-d'),
            'end_date' => now()->endOfMonth()->format('Y-m-d'),
            'category_id' => $catId,
            'is_active' => 1,
        ]);

        $response->assertRedirect(route('budgets.index'));
        $this->assertDatabaseHas('budgets', ['id' => $budget->id, 'name' => 'Teste Orçamento 2']);

        $response = $this->delete(route('budgets.destroy', ['id' => $budget->id]));
        $response->assertRedirect(route('budgets.index'));
        $this->assertDatabaseMissing('budgets', ['id' => $budget->id]);
    }
}
