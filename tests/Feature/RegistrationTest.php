<?php

namespace Tests\Feature;

use App\Actions\GenerateUsername;
use App\Http\Controllers\SocialiteCallbackController;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Jetstream;
use Laravel\Socialite\Contracts\Factory as SocialiteFactory;
use Laravel\Socialite\Two\GithubProvider;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->markTestSkipped('Registeration is disabled because we have only GitHub login');
    }

    public function test_registration_screen_can_be_rendered(): void
    {
        if (! Features::enabled(Features::registration())) {
            $this->markTestSkipped('Registration support is not enabled.');
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
        $dummyUser = User::factory()->make();

        $this->post('/register', [
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

    public function test_github_registration_fills_github_url(): void
    {
        $this->mock(SocialiteFactory::class, function (MockInterface $mock) {
            $mockUser = tap(new \Laravel\Socialite\Two\User)->map([
                'email' => 'foo@bar.com',
                'name' => 'Brent Roose',
                'nickname' => 'brendt',
            ]);

            $mockedDriver = Mockery::mock(GithubProvider::class);
            $mockedDriver->shouldReceive('user')->andReturn($mockUser);

            $mock->shouldReceive('driver')->with('github')->andReturn($mockedDriver);
        });

        $this->get(action(SocialiteCallbackController::class, ['driver' => 'github', 'code' => 200]));

        $this->assertDatabaseHas(User::class, [
            'github_url' => 'https://github.com/brendt',
        ]);
    }

    public static function validationDataProvider(): array
    {
        return [
            'Username is required' => ['username', ['username' => null]],
            'Username must have a minimum length of 2' => ['username', ['username' => '']],
            'Username must have a maximum length of 50' => [
                'username',
                ['username' => (new GenerateUsername)(Str::random(51))],
            ],
            'Username must follow a slug like format' => ['username', ['username' => 'this is not ok']],
            'Username should not start with hyphen' => ['username', ['username' => '-this-is-not-ok']],
            'Username should not end with hyphen' => ['username', ['username' => 'this-is-not-ok-']],
            'Username should not start with underscore' => ['username', ['username' => '_this-is-not-ok']],
            'Username should not end with underscore' => ['username', ['username' => 'this-is-not-ok_']],
            'Username is unique' => ['username', ['username' => 'test']],
        ];
    }
}
