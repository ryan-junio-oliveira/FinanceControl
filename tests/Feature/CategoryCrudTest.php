<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Modules\Organization\Infrastructure\Persistence\Eloquent\OrganizationModel as Organization;
use App\Models\User;
use App\Modules\Category\Infrastructure\Persistence\Eloquent\CategoryModel as Category;

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

        // filter by investment type should not show expense/recipe
        $response2 = $this->get(route('categories.index', ['type' => 'investment']));
        $response2->assertStatus(200);
        $response2->assertDontSee('Cat A');
        $response2->assertDontSee('Cat B');
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

        // also able to create investment type
        $response2 = $this->post(route('categories.store'), [
            'name' => 'CDB',
            'type' => 'investment',
        ]);
        // debug response if it fails
        if (! $response2->isRedirect(route('categories.index'))) {
            dump('response status', $response2->status());
            dump('response content', $response2->getContent());
            dump('session errors', $response2->getSession()->get('errors')?->all());
        }
        $response2->assertRedirect(route('categories.index'));
        $this->assertDatabaseHas('categories', ['name' => 'CDB', 'type' => 'investment', 'organization_id' => $org->id]);

        // filtered listing should show the new investment category
        $response3 = $this->get(route('categories.index', ['type' => 'investment']));
        $response3->assertStatus(200);
        $response3->assertSee('CDB');
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
