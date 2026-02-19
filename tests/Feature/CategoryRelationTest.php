<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Organization;
use App\Models\User;
use App\Models\Category;
use App\Models\Recipe;

class CategoryRelationTest extends TestCase
{
    use RefreshDatabase;

    public function test_recipe_can_be_assigned_category_of_same_org_and_type()
    {
        $org = Organization::create(['name' => 'Org A']);
        $user = User::factory()->create(['organization_id' => $org->id]);
        $this->actingAs($user);

        $cat = Category::create(['name' => 'Vendas', 'type' => 'recipe', 'organization_id' => $org->id]);

        $response = $this->post(route('recipes.store'), [
            'name' => 'Teste',
            'amount' => 10.00,
            'transaction_date' => now()->format('Y-m-d'),
            'category_id' => $cat->id,
        ]);

        $response->assertRedirect(route('recipes.index'));
        $this->assertDatabaseHas('recipes', ['name' => 'Teste', 'category_id' => $cat->id]);

        $recipe = Recipe::first();
        $this->assertEquals($cat->id, $recipe->category->id);
    }

    public function test_expense_category_must_belong_to_same_organization_and_type()
    {
        $org1 = Organization::create(['name' => 'Org A']);
        $org2 = Organization::create(['name' => 'Org B']);

        $user = User::factory()->create(['organization_id' => $org1->id]);
        $this->actingAs($user);

        $catOtherOrg = Category::create(['name' => 'Other', 'type' => 'expense', 'organization_id' => $org2->id]);
        $catWrongType = Category::create(['name' => 'Wrong', 'type' => 'recipe', 'organization_id' => $org1->id]);

        // category from other organization should fail validation
        $response = $this->post(route('expenses.store'), [
            'name' => 'Teste',
            'amount' => 5.0,
            'transaction_date' => now()->format('Y-m-d'),
            'category_id' => $catOtherOrg->id,
        ]);
        $response->assertSessionHasErrors('category_id');

        // category with wrong type should also fail
        $response = $this->post(route('expenses.store'), [
            'name' => 'Teste 2',
            'amount' => 6.0,
            'transaction_date' => now()->format('Y-m-d'),
            'category_id' => $catWrongType->id,
        ]);
        $response->assertSessionHasErrors('category_id');
    }
}
