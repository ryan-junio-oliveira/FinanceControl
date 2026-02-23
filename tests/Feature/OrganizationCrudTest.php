<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Modules\Organization\Infrastructure\Persistence\Eloquent\OrganizationModel as Organization;
use App\Models\User;
use Carbon\Carbon;

class OrganizationCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\UserSeeder::class);
    }

    public function test_update_organization_name()
    {
        $org = Organization::create(['name' => 'Orig']);
        $user = User::factory()->create(['organization_id' => $org->id]);
        $user->assignRole('gestor');
        $this->actingAs($user);

        $response = $this->put(route('organization.update'), ['name' => 'New Name']);
        $response->assertRedirect(route('organization.edit'));
        $this->assertDatabaseHas('organizations', ['id' => $org->id, 'name' => 'New Name']);
    }

    public function test_invite_and_remove_member()
    {
        $org = Organization::create(['name' => 'Team']);
        $user = User::factory()->create(['organization_id' => $org->id]);
        $user->assignRole('gestor');
        $this->actingAs($user);

        $response = $this->post(route('organization.invite'), ['username' => 'newuser', 'email' => 'new@example.com']);
        $response->assertRedirect(route('organization.edit'));

        $this->assertDatabaseHas('users', ['username' => 'newuser', 'email' => 'new@example.com', 'organization_id' => $org->id]);

        $new = User::where('email', 'new@example.com')->first();
        $response = $this->delete(route('organization.members.remove', $new));
        $response->assertRedirect(route('organization.edit'));
        $this->assertDatabaseHas('users', ['id' => $new->id, 'organization_id' => null]);
    }

    public function test_archive_unarchive_and_purge()
    {
        $org = Organization::create(['name' => 'ToArchive']);
        $user = User::factory()->create(['organization_id' => $org->id]);
        $user->assignRole('gestor');
        $this->actingAs($user);

        $response = $this->post(route('organization.archive'));
        $response->assertRedirect(route('organization.edit'));

        $this->assertDatabaseMissing('organizations', ['id' => $org->id, 'archived_at' => null]);

        // Simulate archive older than 6 months and ensure command deletes it
        $old = Organization::create(['name' => 'OldOrg']);
        $old->archived_at = Carbon::now()->subMonths(7);
        $old->save();

        $this->artisan('organizations:purge-archived')->assertExitCode(0);
        $this->assertDatabaseMissing('organizations', ['id' => $old->id]);

        // Unarchive
        $response = $this->post(route('organization.unarchive'));
        $response->assertRedirect(route('organization.edit'));
        $this->assertDatabaseHas('organizations', ['id' => $org->id, 'archived_at' => null]);
    }
}
