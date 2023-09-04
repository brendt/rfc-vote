<?php

namespace Tests\Feature;

use App\Actions\CreateVerificationRequest;
use App\Http\Controllers\VerificationRequestsAdminController;
use App\Http\Livewire\VerificationRequestsList;
use App\Models\Message;
use App\Models\VerificationRequest;
use App\Models\VerificationRequestStatus;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CreateVerificationRequestTest extends TestCase
{
    use LazilyRefreshDatabase;

    /** @test */
    public function test_user_can_create_verification_request()
    {
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
    }


    public function test_verification_requests_page_can_be_rendered()
    {
        $this->login(isAdmin: true);

        $this->get(action(VerificationRequestsAdminController::class))
            ->assertSeeLivewire('verification-requests-list')
            ->assertViewIs("verification-request-admin");
    }


    public function test_verification_list_component()
    {
        $this->login(isAdmin: true);

        $pendingRequests = VerificationRequest::factory(3)->create();

        Livewire::test(VerificationRequestsList::class)
            ->assertViewIs('livewire.verification-requests-list')
            ->assertSee($pendingRequests[0]->user->name)
            ->assertSee($pendingRequests[0]->motivation)
            ->assertOk();
    }


    function test_admin_can_accept_verification_request()
    {
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
            'status' => VerificationRequestStatus::ACCEPTED
        ]);
    }

    function test_admin_can_deny_verification_request()
    {
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
            'status' => VerificationRequestStatus::DENIED
        ]);
    }
}
