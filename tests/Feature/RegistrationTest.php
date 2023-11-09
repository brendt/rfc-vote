<?php

use App\Actions\GenerateUsername;
use App\Http\Controllers\SocialiteCallbackController;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Jetstream;
use Laravel\Socialite\Contracts\Factory as SocialiteFactory;
use Laravel\Socialite\Two\GithubProvider;
use Mockery\MockInterface;

test('registration screen can be rendered', function () {
    if (! Features::enabled(Features::registration())) {
        $this->markTestSkipped('Registration support is not enabled.');
    }

    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
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
});

test('has proper validation rules', function (string $fieldKey, array $inputData) {
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
})->with('validationDataProvider');

test('registration form contains username component', function () {
    $this->get('/register')->assertSeeLivewire('username-input');
});

test('github registration fills github url', function () {
    $this->mock(SocialiteFactory::class, function (MockInterface $mock) {
        $mockUser = tap(new \Laravel\Socialite\Two\User())->map([
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
});

dataset('validationDataProvider', function () {
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
});
