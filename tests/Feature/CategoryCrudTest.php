<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Organization;
use App\Models\User;
use App\Models\Category;

class CategoryCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_shows_only_organization_categories()
    {
        $org1 = Organization::create(['name' => 'Org 1']);
        $org2 = Organization::create(['name' => 'Org 2']);

        Category::create(['name' => 'Cat A', 'type' => 'recipe', 'organization_id' => $org1->id]);
        Category::create(['name' => 'Cat B', 'type' => 'expense', 'organization_id' => $org2->id]);

        $user = User::factory()->create(['organization_id' => $org1->id]);
        $this->actingAs($user);

        $response = $this->get(route('categories.index'));
        $response->assertStatus(200);
        $response->assertSee('Cat A');
        $response->assertDontSee('Cat B');
    }

    public function test_store_creates_category()
    {
        $org = Organization::create(['name' => 'ACME']);
        $user = User::factory()->create(['organization_id' => $org->id]);
        $this->actingAs($user);

        $response = $this->post(route('categories.store'), [
            'name' => 'Vendas',
            'type' => 'recipe',
        ]);

        $response->assertRedirect(route('categories.index'));
        $this->assertDatabaseHas('categories', ['name' => 'Vendas', 'organization_id' => $org->id]);
    }

    public function test_update_category()
    {
        $org = Organization::create(['name' => 'ACME']);
        $user = User::factory()->create(['organization_id' => $org->id]);
        $this->actingAs($user);

        $cat = Category::create(['name' => 'Old', 'type' => 'expense', 'organization_id' => $org->id]);

        $response = $this->put(route('categories.update', $cat), [
            'name' => 'New name',
            'type' => 'expense',
        ]);

        $response->assertRedirect(route('categories.index'));
        $this->assertDatabaseHas('categories', ['id' => $cat->id, 'name' => 'New name']);
    }

    public function test_destroy_category()
    {
        $org = Organization::create(['name' => 'ACME']);
        $user = User::factory()->create(['organization_id' => $org->id]);
        $this->actingAs($user);

        $cat = Category::create(['name' => 'To remove', 'type' => 'recipe', 'organization_id' => $org->id]);

        $response = $this->delete(route('categories.destroy', $cat));
        $response->assertRedirect(route('categories.index'));

        $this->assertDatabaseMissing('categories', ['id' => $cat->id]);
    }
}
