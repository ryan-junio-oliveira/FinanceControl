<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Modules\Organization\Infrastructure\Persistence\Eloquent\OrganizationModel as Organization;
use App\Modules\Admin\Infrastructure\Persistence\Eloquent\BankModel;
use App\Modules\Admin\Infrastructure\Persistence\Eloquent\CategoryModel;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    protected User $root;

    protected function setUp(): void
    {
        parent::setUp();
        // run seeder to make sure roles exist
        $this->seed(\Database\Seeders\UserSeeder::class);

        $this->root = User::factory()->create(['organization_id' => null]);
        $this->root->assignRole('root');
    }

    public function test_regular_user_cannot_access_admin_routes()
    {
        $org = Organization::create(['name' => 'Foo']);
        $user = User::factory()->create(['organization_id' => $org->id]);

        $this->actingAs($user);

        $this->get(route('admin.banks.index'))->assertStatus(403);
        $this->post(route('admin.banks.store'), ['name' => 'X'])->assertStatus(403);
        $this->get(route('admin.categories.index'))->assertStatus(403);
    }

    public function test_root_can_crud_banks()
    {
        $this->actingAs($this->root);

        // menu should include admin entries
        $html = $this->get('/dashboard')->getContent();
        $this->assertStringContainsString('/admin/banks', $html);
        $this->assertStringContainsString('/admin/categories', $html);

        // index initially empty
        $this->get(route('admin.banks.index'))->assertStatus(200)->assertSee('Nenhum banco encontrado');

        // create
        $this->post('/admin/banks', ['name' => 'Banco1'])->assertRedirect(route('admin.banks.index'));
        $this->assertDatabaseHas('banks', ['name' => 'Banco1']);

        $bank = BankModel::first();

        // edit
        $this->get("/admin/banks/{$bank->id}/edit")->assertStatus(200);
        $this->put("/admin/banks/{$bank->id}", ['name' => 'Banco2'])->assertRedirect(route('admin.banks.index'));
        $this->assertDatabaseHas('banks', ['id' => $bank->id, 'name' => 'Banco2']);

        // delete
        $this->delete("/admin/banks/{$bank->id}")->assertRedirect(route('admin.banks.index'));
        $this->assertDatabaseMissing('banks', ['id' => $bank->id]);
    }

    public function test_root_can_crud_categories()
    {
        $this->actingAs($this->root);

        $org1 = Organization::create(['name' => 'Org1']);
        $org2 = Organization::create(['name' => 'Org2']);

        $this->get('/admin/categories')->assertStatus(200);

        // create
        $data = ['name' => 'Cat1', 'type' => 'expense', 'organization_id' => $org1->id];
        $this->post('/admin/categories', $data)->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', ['name' => 'Cat1', 'organization_id' => $org1->id]);

        $cat = CategoryModel::first();

        // edit
        $this->get("/admin/categories/{$cat->id}/edit")->assertStatus(200);
        $this->put("/admin/categories/{$cat->id}", ['name' => 'Cat2', 'type' => 'recipe', 'organization_id' => $org2->id])
             ->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', ['id' => $cat->id, 'name' => 'Cat2', 'organization_id' => $org2->id]);

        // destroy
        $this->delete("/admin/categories/{$cat->id}")->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseMissing('categories', ['id' => $cat->id]);
    }
}
