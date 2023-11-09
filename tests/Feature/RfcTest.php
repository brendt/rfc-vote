<?php

use App\Http\Controllers\EndRfcController;
use App\Http\Controllers\PublishRfcController;
use App\Http\Controllers\RfcAdminController;
use App\Http\Controllers\RfcCreateController;
use App\Http\Controllers\RfcEditController;
use App\Http\Controllers\RfcMetaImageController;
use App\Models\Rfc;
use Carbon\Carbon;

uses(\Illuminate\Foundation\Testing\WithFaker::class);

test('rfc management only accessible by admin', function () {
    $this->login();

    $this->get('/admin/rfc')
        ->assertRedirect('/');
});

test('rfc management page can be rendered', function () {
    $this->login(null, true);

    $this->get(action(RfcAdminController::class))
        ->assertViewIs('rfc-admin')
        ->assertOk();
});

test('create rfc screen can be rendered', function () {
    $this->login(null, true);

    $this->get(action([RfcCreateController::class, 'create']))
        ->assertViewIs('rfc-form')
        ->assertOk();
});

test('create rfc returns validation errors', function () {
    $this->login(null, true);

    $this->post(action([RfcCreateController::class, 'store']))
        ->assertSessionHasErrors(['title', 'description', 'url']);
});

it('can create rfc', function () {
    $this->login(null, true);

    $this->withoutExceptionHandling();

    $this->post(action([RfcCreateController::class, 'store']), [
        'title' => $this->faker->text(10),
        'teaser' => $this->faker->text(50),
        'description' => $this->faker->text(50),
        'url' => $this->faker->url,
    ])
        ->assertRedirect();

    $this->assertDatabaseCount('rfcs', 1);
});

test('edit rfc screen can be rendered', function () {
    $rfc = Rfc::factory()->create();
    $this->login(null, true);

    $this->get(action([RfcEditController::class, 'edit'], $rfc))
        ->assertViewIs('rfc-form')
        ->assertSee($rfc->title)
        ->assertSee($rfc->url)
        ->assertSee($rfc->id)
        ->assertSee($rfc->description)
        ->assertOk();
});

test('rfc can be updated', function () {
    $rfc = Rfc::factory()->create();

    $this->login(isAdmin: true);

    $newUrl = $this->faker->url;

    $this->post(action([RfcEditController::class, 'update'], $rfc),
        [
            'title' => 'updated_title',
            'description' => 'updated_description',
            'teaser' => 'updated_teaser',
            'url' => $newUrl,
        ])
        ->assertRedirect(action([RfcEditController::class, 'update'], $rfc));

    $this->assertDatabaseCount('rfcs', 1);
    $this->assertDatabaseHas('rfcs', [
        'title' => 'updated_title',
        'description' => 'updated_description',
        'teaser' => 'updated_teaser',
        'url' => $newUrl,
    ]);
});

test('rfc can be published', function () {
    $rfc = Rfc::factory()->create();
    $this->login(null, true);
    $this->post(action(PublishRfcController::class, $rfc))
        ->assertRedirect(action(RfcAdminController::class));
});

test('rfc can be ended', function () {
    $rfc = Rfc::factory()->create();
    $this->login(null, true);
    $this->post(action(EndRfcController::class, $rfc))
        ->assertRedirect(action(RfcAdminController::class));
});

test('rfc meta image has no cache headers', function () {
    $rfc = Rfc::factory()->create();
    $response = $this->get(action(RfcMetaImageController::class, $rfc))
        ->assertHeader('Content-Type', 'image/png')
        ->assertHeader('Cache-Control', 'max-age=900, public, s-maxage=900, stale-if-error=900, stale-while-revalidate=900');

    $expires = $response->headers->get('Expires');

    expect(Carbon::parse($expires)->format('d-m-Y'))->toEqual(now()->format('d-m-Y'));
});
