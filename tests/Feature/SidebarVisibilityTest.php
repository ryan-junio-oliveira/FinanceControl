<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SidebarVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_does_not_see_sidebar_links()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        // as guest sidebar should not render anywhere; specifically budgets link
        $response->assertDontSee('Orçamentos');
        $response->assertDontSee('Receitas');
        $response->assertDontSee('Despesas');
    }

    public function test_authenticated_user_sees_budget_link()
    {
        // create organization and user so the budget controller has an org id
        $orgId = \DB::table('organizations')->insertGetId(['name' => 'Org Test']);
        $user = \App\Models\User::factory()->create(['organization_id' => $orgId]);
        $this->actingAs($user);

        $response = $this->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Orçamentos');

        // the budgets route should be accessible without redirecting to login
        $budgets = $this->get('/budgets');
        $budgets->assertStatus(200);
        $budgets->assertSee('Orçamentos');
    }
}
