<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class CreditCardCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_update_and_delete_credit_card()
    {
        $orgId = DB::table('organizations')->insertGetId(['name' => 'Org C']);
        $user = User::factory()->create(['organization_id' => $orgId]);
        $this->actingAs($user);

        // index page should be accessible even if there are no cards yet
        $this->get(route('credit-cards.index'))->assertStatus(200);

        // need a bank for the card (banks table has no organization_id)
        $bankId = DB::table('banks')->insertGetId(['name' => 'Test Bank']);

        $response = $this->post(route('credit-cards.store'), [
            'name' => 'My Card',
            'bank_id' => $bankId,
            'statement_amount' => 500.00,
            'limit' => 1000.00,
            'closing_day' => 25,
            'due_day' => 5,
            'color' => '#abcdef',
            'is_active' => 1,
        ]);

        $response->assertRedirect(route('credit-cards.index'));
        $this->assertDatabaseHas('credit_cards', ['name' => 'My Card', 'organization_id' => $orgId]);

        $card = DB::table('credit_cards')->where('organization_id', $orgId)->first();

        $response = $this->put(route('credit-cards.update', ['id' => $card->id]), [
            'name' => 'My Card Updated',
            'bank_id' => $bankId,
            'statement_amount' => 750.00,
            'limit' => 2000.00,
            'closing_day' => 27,
            'due_day' => 6,
            'color' => '#123456',
            'is_active' => 0,
        ]);

        $response->assertRedirect(route('credit-cards.index'));
        $this->assertDatabaseHas('credit_cards', ['id' => $card->id, 'name' => 'My Card Updated']);

        $response = $this->delete(route('credit-cards.destroy', ['id' => $card->id]));
        $response->assertRedirect(route('credit-cards.index'));
        $this->assertDatabaseMissing('credit_cards', ['id' => $card->id]);
    }
}
