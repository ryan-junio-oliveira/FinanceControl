<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class InvestmentCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_update_and_delete_investment()
    {
        $orgId = DB::table('organizations')->insertGetId(['name' => 'Org A']);
        $user = User::factory()->create(['organization_id' => $orgId]);
        $this->actingAs($user);

        // create an investment
        $response = $this->post(route('investments.store'), [
            'name' => 'Compra de ações',
            'amount' => 1200.00,
            'transaction_date' => now()->format('Y-m-d'),
            'fixed' => 0,
        ]);
        $response->assertRedirect(route('investments.index'));
        $this->assertDatabaseHas('investments', ['name' => 'Compra de ações', 'organization_id' => $orgId]);

        $inv = DB::table('investments')->where('organization_id', $orgId)->first();

        $response = $this->put(route('investments.update', ['id' => $inv->id]), [
            'name' => 'Compra de CDB',
            'amount' => 1500.00,
            'transaction_date' => now()->format('Y-m-d'),
            'fixed' => 1,
        ]);
        $response->assertRedirect(route('investments.index'));
        $this->assertDatabaseHas('investments', ['id' => $inv->id, 'name' => 'Compra de CDB']);

        $response = $this->delete(route('investments.destroy', ['id' => $inv->id]));
        $response->assertRedirect(route('investments.index'));
        $this->assertDatabaseMissing('investments', ['id' => $inv->id]);
    }
}
