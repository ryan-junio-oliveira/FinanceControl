<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class StyleGuideTest extends TestCase
{
    use RefreshDatabase;

    public function test_palette_page_visible_to_authenticated_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('style.palette'));
        $response->assertStatus(200);
        $response->assertSee('--color-brand-500');
        $response->assertSee('#005E7D');
    }

    public function test_palette_redirects_guest_to_login()
    {
        $response = $this->get('/styleguide/palette');
        $response->assertRedirect('/login');
    }
}
