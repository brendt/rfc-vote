<?php

namespace Tests\Unit;

use App\Actions\GenerateUsername;
use App\Models\User;
use Tests\TestCase;

class GenerateUsernameActionTest extends TestCase
{
	public function test_username_generation_for_user(): void
	{
        $user = User::factory()->create(['name' => 'John Doe']);

        $username = (new GenerateUsername)($user);

        $this->assertEquals('john-doe', $username);
	}

    public function test_username_generation_for_string(): void
    {
        $username = (new GenerateUsername)('one two three');

        $this->assertEquals('one-two-three', $username);
    }
}
