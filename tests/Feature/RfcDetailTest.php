<?php

use App\Http\Controllers\RfcDetailController;
use App\Models\Rfc;

test('as guest', function () {
    $rfc = Rfc::factory()->create();

    $this->get(action(RfcDetailController::class, $rfc))
        ->assertSuccessful()
        ->assertSee($rfc->title);
});

test('as user', function () {
    $rfc = Rfc::factory()->create();

    $this->login();

    $this->get(action(RfcDetailController::class, $rfc))
        ->assertSuccessful()
        ->assertSee($rfc->title);
});

test('as admin', function () {
    $rfc = Rfc::factory()->create();

    $this->login(isAdmin: true);

    $this->get(action(RfcDetailController::class, $rfc))
        ->assertSuccessful()
        ->assertSee($rfc->title);
});
