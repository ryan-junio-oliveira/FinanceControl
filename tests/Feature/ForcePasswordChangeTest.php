<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class ForcePasswordChangeTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_flagged_must_change_is_redirected_to_force_change()
    {
        $user = User::factory()->create(['must_change_password' => true]);
        $this->actingAs($user);

        $response = $this->get(route('dashboard'));
        $response->assertRedirect(route('password.force'));
    }

    public function test_user_can_view_and_submit_force_change_form()
    {
        $user = User::factory()->create(['must_change_password' => true]);
        $this->actingAs($user);

        $response = $this->get(route('password.force'));
        $response->assertStatus(200);

        $response = $this->post(route('password.force.update'), [
            'password' => 'newsecurepassword',
            'password_confirmation' => 'newsecurepassword',
        ]);

        $response->assertRedirect(route('dashboard'));

        $user->refresh();
        $this->assertFalse($user->must_change_password);
    }

    public function test_user_without_flag_is_not_redirected()
    {
        $user = User::factory()->create(['must_change_password' => false]);
        $this->actingAs($user);

        $response = $this->get(route('dashboard'));
        $response->assertStatus(200);
    }
}
