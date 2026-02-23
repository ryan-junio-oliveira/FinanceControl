<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Modules\Organization\Infrastructure\Persistence\Eloquent\OrganizationModel as Organization;

class RoleAssignmentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\UserSeeder::class);
    }

    public function test_registration_assigns_gestor_role()
    {
        $response = $this->post('/register', [
            'username' => 'owner',
            'email' => 'owner@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'organization_name' => 'OrgName',
        ]);

        $response->assertRedirect('/login');
        $user = User::where('email', 'owner@example.com')->first();
        $this->assertNotNull($user);
        $this->assertTrue($user->hasRole('gestor'));
    }

    public function test_seed_creates_root_and_admin_roles()
    {
        // setUp already seeded; just verify roles exist on the generated users
        $root = User::where('email', 'root@example.com')->first();
        $admin = User::where('email', 'admin@example.com')->first();

        $this->assertTrue($root->hasRole('root'));
        $this->assertTrue($admin->hasRole('gestor'));
    }

    public function test_non_gestor_cannot_manage_organization()
    {
        $org = Organization::create(['name' => 'Foo']);
        $user = User::factory()->create(['organization_id' => $org->id]);
        // no role grants
        $this->actingAs($user);

        $response = $this->post(route('organization.invite'), ['username' => 'bad', 'email' => 'bad@example.com']);
        $response->assertStatus(403);
    }

    public function test_root_user_sees_settings_menu_item()
    {
        $root = User::factory()->create(['organization_id' => null]);
        $root->assignRole('root');
        $this->actingAs($root);

        $html = $this->get('/dashboard')->getContent();
        $this->assertStringContainsString('/admin/settings', $html);
        $this->assertStringContainsString('/admin/banks', $html);
        $this->assertStringContainsString('/admin/categories', $html);
    }

    public function test_regular_user_does_not_see_settings_menu_item()
    {
        $org = Organization::create(['name' => 'Bar']);
        $user = User::factory()->create(['organization_id' => $org->id]);
        $this->actingAs($user);

        $html = $this->get('/dashboard')->getContent();
        $this->assertStringNotContainsString('/admin/settings', $html);
        $this->assertStringNotContainsString('/admin/banks', $html);
        $this->assertStringNotContainsString('/admin/categories', $html);

        // also ensure they can't view the page directly
        $this->get('/admin/settings')->assertStatus(403);
        $this->get('/admin/banks')->assertStatus(403);
        $this->get('/admin/categories')->assertStatus(403);
    }
}
