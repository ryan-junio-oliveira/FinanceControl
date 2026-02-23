<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\Organization\Infrastructure\Persistence\Eloquent\OrganizationModel as Organization;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Modules\Shared\Presentation\Notifications\InviteNotification;

class OrganizationInviteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\UserSeeder::class);
    }

    public function test_invite_creates_user_with_temporary_password_and_marks_must_change()
    {
        Notification::fake();

        $org = Organization::create(['name' => 'Team']);
        $admin = User::factory()->create(['organization_id' => $org->id]);
        $admin->assignRole('gestor');
        $this->actingAs($admin);

        $response = $this->post(route('organization.invite'), ['username' => 'newuser', 'email' => 'new@example.com']);
        $response->assertRedirect(route('organization.edit'));

        $this->assertDatabaseHas('users', ['username' => 'newuser', 'email' => 'new@example.com', 'organization_id' => $org->id, 'must_change_password' => true]);

        $new = User::where('email', 'new@example.com')->first();
        Notification::assertSentTo($new, InviteNotification::class);

        // role should be assigned
        $this->assertTrue($new->hasRole('member'));
    }
}
