<?php

namespace Tests\Feature;

use App\Actions\GenerateUsername;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Jetstream;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        if (! Features::enabled(Features::registration())) {
            $this->markTestSkipped('Registration support is not enabled.');

            return;
        }

        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        if (! Features::enabled(Features::registration())) {
            $this->markTestSkipped('Registration support is not enabled.');

            return;
        }

        $name = 'Test User';

        $response = $this->post('/register', [
            'name' => $name,
            'username' => (new GenerateUsername)($name),
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    /**
     * @dataProvider validationDataProvider
     */
    public function test_has_proper_validation_rules(string $fieldKey, array $inputData): void
    {
        $controlUser = User::factory()->create(
            [
                'email' => 'test@test.com',
                'username' => 'test',
            ]
        );

        $dummyUser = User::factory()->make();

        $response = $this->post('/register', [
            'name' => $dummyUser->name,
            'username' => $dummyUser->username,
            'email' => $dummyUser->email,
            'password' => 'password',
            'password_confirmation' => 'password',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
            ...$inputData,
        ])->assertSessionHasErrors([$fieldKey]);
    }

    public function test_registration_form_contains_username_component(): void
    {
        $this->get('/register')->assertSeeLivewire('username-input');
    }

    public static function validationDataProvider(): array
    {
        return [
            'Username is required' => ['username', ['username' => null]],
            'Username must have a minimum length of 1' => ['username', ['username' => '']],
            'Username must have a maximum length of 50' => [
                'username',
                ['username' => (new GenerateUsername)(Str::random(51))],
            ],
            'Username must follow a slug like format' => ['username', ['username' => 'this is not ok']],
            'Username must be a string' => ['username', ['username' => ['test']]],
            'Username is unique' => ['username', ['username' => 'test']],
        ];
    }
}
