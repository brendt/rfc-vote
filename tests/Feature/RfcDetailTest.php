<?php

namespace Tests\Feature;

use App\Http\Controllers\RfcDetailController;
use App\Models\Rfc;
use Tests\TestCase;

final class RfcDetailTest extends TestCase
{
    /** @test */
    public function as_guest()
    {
        $rfc = Rfc::factory()->create();

        $this->get(action(RfcDetailController::class, $rfc))
            ->assertSuccessful()
            ->assertSee($rfc->title);
    }

    /** @test */
    public function as_user()
    {
        $rfc = Rfc::factory()->create();

        $this->login();

        $this->get(action(RfcDetailController::class, $rfc))
            ->assertSuccessful()
            ->assertSee($rfc->title);
    }

    /** @test */
    public function as_admin()
    {
        $rfc = Rfc::factory()->create();

        $this->login(isAdmin: true);

        $this->get(action(RfcDetailController::class, $rfc))
            ->assertSuccessful()
            ->assertSee($rfc->title);
    }
}
