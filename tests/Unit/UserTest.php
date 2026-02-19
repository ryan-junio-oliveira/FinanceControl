<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_is_hashed_when_set()
    {
        $user = User::factory()->create(['password' => 'secret']);

        $this->assertTrue(Hash::check('secret', $user->password));
    }

    public function test_must_change_password_defaults_to_false()
    {
        $user = User::factory()->create();
        $this->assertFalse($user->must_change_password);
    }
}
