<?php

namespace Tests\Feature\Profile;

use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdateProfileTest extends TestCase
{
    private string $url;

    public function setUp(): void
    {
        parent::setUp();
        $this->url = action([ProfileController::class, 'update']);
    }

    public function test_user_can_update_name_and_username(): void
    {
        $user = User::factory()->create();

        $formData = [
            'name' => 'Anna',
            'username' => 'anna',
        ];

        $this->actingAs($user)->post($this->url, $formData);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            ...$formData,
        ]);
    }

    public function test_user_can_update_urls(): void
    {
        $user = User::factory()->create();

        $formData = [
            'name' => 'Anna',
            'username' => 'anna',
            'website_url' => 'https://anna.com',
            'twitter_url' => 'https://twitter.com/anna',
            'github_url' => 'https://github.com/anna',
        ];

        $this->actingAs($user)->post($this->url, $formData);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            ...$formData,
        ]);
    }

    public function test_username_is_required(): void
    {
        $user = User::factory()->create();

        $formData = ['name' => 'Sam'];

        $this->actingAs($user)
            ->post($this->url, $formData)
            ->assertSessionHasErrors('username');
    }

    public function test_name_is_required(): void
    {
        $user = User::factory()->create();

        $formData = ['username' => 'serhii-cho'];

        $this->actingAs($user)
            ->post($this->url, $formData)
            ->assertSessionHasErrors('name');
    }

    public function test_name_cannot_be_more_than_255_characters(): void
    {
        $user = User::factory()->create();

        $formData = [
            'name' => str_repeat('a', 256),
            'username' => 'anna',
        ];

        $this->actingAs($user)
            ->post($this->url, $formData)
            ->assertSessionHasErrors('name');
    }

    public function test_username_cannot_be_more_than_255_characters(): void
    {
        $user = User::factory()->create();

        $formData = [
            'username' => str_repeat('a', 256),
            'name' => 'anna',
        ];

        $this->actingAs($user)
            ->post($this->url, $formData)
            ->assertSessionHasErrors('username');
    }

    public function test_website_url_cannot_be_more_than_255_characters(): void
    {
        $user = User::factory()->create();

        $formData = [
            'username' => 'anna',
            'name' => 'Anna',
            'website_url' => str_repeat('a', 256),
        ];

        $this->actingAs($user)
            ->post($this->url, $formData)
            ->assertSessionHasErrors('website_url');
    }

    public function test_github_url_cannot_be_more_than_255_characters(): void
    {
        $user = User::factory()->create();

        $formData = [
            'username' => 'anna',
            'name' => 'Anna',
            'github_url' => str_repeat('a', 256),
        ];

        $this->actingAs($user)
            ->post($this->url, $formData)
            ->assertSessionHasErrors('github_url');
    }

    public function test_twitter_url_cannot_be_more_than_255_characters(): void
    {
        $user = User::factory()->create();

        $formData = [
            'username' => 'anna',
            'name' => 'Anna',
            'twitter_url' => str_repeat('a', 256),
        ];

        $this->actingAs($user)
            ->post($this->url, $formData)
            ->assertSessionHasErrors('twitter_url');
    }

    public function test_it_saves_avatar(): void
    {
        $user = User::factory()->create();
        Storage::fake();

        $formData = [
            'username' => 'anna',
            'name' => 'Anna',
            'avatar' => UploadedFile::fake()->image('avatar.jpg'),
        ];

        $this->actingAs($user)->post($this->url, $formData);

        $fileName = $formData['avatar']->hashName();

        Storage::assertExists("public/avatars/{$fileName}");

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'avatar' => "public/avatars/{$fileName}",
        ]);
    }

    public function test_avatar_is_not_updated_to_null_when_avatar_in_request_is_null(): void
    {
        $avatar = 'public/avatars/alex.jpg';
        $user = User::factory()->create(compact('avatar'));

        $formData = [
            'username' => 'alex',
            'name' => 'alex',
            'avatar' => null,
        ];

        $this->actingAs($user)->post($this->url, $formData);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'avatar' => $avatar,
        ]);
    }

    public function test_avatar_is_not_updated_to_null_when_not_provided(): void
    {
        $avatar = 'public/avatars/sam.jpg';
        $user = User::factory()->create(compact('avatar'));

        $formData = [
            'username' => 'sam',
            'name' => 'Sam',
        ];

        $this->actingAs($user)->post($this->url, $formData);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'avatar' => $avatar,
        ]);
    }
}
