<?php

use App\Actions\CreateVerificationRequest;
use App\Http\Controllers\VerificationRequestsAdminController;
use App\Http\Livewire\VerificationRequestsList;
use App\Models\Message;
use App\Models\VerificationRequest;
use App\Models\VerificationRequestStatus;
use Livewire\Livewire;

uses(\Illuminate\Foundation\Testing\LazilyRefreshDatabase::class);

test('user can create verification request', function () {
    $admin = $this->login(isAdmin: true);
    $user = $this->login();

    app(CreateVerificationRequest::class)(
        user: $user,
        motivation: 'test',
    );

    $user->refresh();

    $this->assertDatabaseHas(VerificationRequest::class, [
        'user_id' => $user->id,
        'motivation' => 'test',
    ]);

    $this->assertDatabaseHas(Message::class, [
        'user_id' => $admin->id,
        'sender_id' => $user->id,
        'url' => action(VerificationRequestsAdminController::class),
    ]);
});

test('verification requests page can be rendered', function () {
    $this->login(isAdmin: true);

    $this->get(action(VerificationRequestsAdminController::class))
        ->assertSeeLivewire('verification-requests-list')
        ->assertViewIs('verification-request-admin');
});

test('verification list component', function () {
    $this->login(isAdmin: true);

    $pendingRequests = VerificationRequest::factory(3)->create();

    Livewire::test(VerificationRequestsList::class)
        ->assertViewIs('livewire.verification-requests-list')
        ->assertSee($pendingRequests[0]->user->name)
        ->assertSee($pendingRequests[0]->motivation)
        ->assertOk();
});

test('admin can accept verification request', function () {
    $this->login(isAdmin: true);
    $pendingRequest = VerificationRequest::factory()->create();

    Livewire::test(VerificationRequestsList::class)
        ->assertViewIs('livewire.verification-requests-list')
        ->assertSee($pendingRequest->user->name)
        ->assertSee($pendingRequest->motivation)
        ->call('accept', $pendingRequest)
        ->assertSet('isAccepting', $pendingRequest)
        ->assertSeeHtml('select')
        ->call('accept', $pendingRequest)
        ->assertNotSet('flair', null)
        ->assertOk();

    $this->assertDatabaseHas('verification_requests', [
        'id' => $pendingRequest->id,
        'status' => VerificationRequestStatus::ACCEPTED,
    ]);
});

test('admin can deny verification request', function () {
    $this->login(isAdmin: true);
    $pendingRequest = VerificationRequest::factory()->create();

    Livewire::test(VerificationRequestsList::class)
        ->assertViewIs('livewire.verification-requests-list')
        ->assertSee($pendingRequest->user->name)
        ->assertSee($pendingRequest->motivation)
        ->call('deny', $pendingRequest)
        ->assertSet('isDenying', $pendingRequest)
        ->call('deny', $pendingRequest)
        ->assertOk();

    $this->assertDatabaseHas('verification_requests', [
        'id' => $pendingRequest->id,
        'status' => VerificationRequestStatus::DENIED,
    ]);
});
