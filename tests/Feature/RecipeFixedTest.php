<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Modules\Organization\Infrastructure\Persistence\Eloquent\OrganizationModel as Organization;
use App\Models\User;
use App\Modules\Recipe\Infrastructure\Persistence\Eloquent\RecipeModel as Recipe;
use App\Modules\Admin\Infrastructure\Persistence\Eloquent\CategoryModel as Category;

class RecipeFixedTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_recipe_with_fixed_flag()
    {
        $org = Organization::create(['name' => 'Org A']);
        $user = User::factory()->create(['organization_id' => $org->id]);
        $this->actingAs($user);

        $cat = Category::create(['name' => 'Padrao', 'type' => 'recipe', 'organization_id' => $org->id]);

        $response = $this->post(route('recipes.store'), [
            'name' => 'Rec Fixa',
            'amount' => 100.00,
            'transaction_date' => now()->format('Y-m-d'),
            'fixed' => 1,
            'category_id' => $cat->id,
        ]);

        $response->assertRedirect(route('recipes.index'));
        $this->assertDatabaseHas('recipes', ['name' => 'Rec Fixa', 'fixed' => 1, 'organization_id' => $org->id]);
    }

    public function test_update_recipe_toggle_fixed_flag()
    {
        $org = Organization::create(['name' => 'Org A']);
        $user = User::factory()->create(['organization_id' => $org->id]);
        $this->actingAs($user);

        $cat = Category::create(['name' => 'Padrao', 'type' => 'recipe', 'organization_id' => $org->id]);

        $recipe = Recipe::create([
            'name' => 'Rec',
            'amount' => 50.00,
            'transaction_date' => now()->format('Y-m-d'),
            'fixed' => false,
            'organization_id' => $org->id,
            'category_id' => $cat->id,
        ]);

        $response = $this->put(route('recipes.update', $recipe), [
            'name' => 'Rec',
            'amount' => 50.00,
            'transaction_date' => now()->format('Y-m-d'),
            'fixed' => 1,
            'category_id' => $cat->id,
        ]);

        $response->assertRedirect(route('recipes.index'));
        $this->assertDatabaseHas('recipes', ['id' => $recipe->id, 'fixed' => 1]);
    }
}
