<?php

namespace Tests\Feature;

use App\Models\Rfc;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RfcTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function rfc_management_only_accessible_by_admin()
    {
        $this->login();

        $this->get('/admin/rfc')
            ->assertRedirect('/');
    }

    /** @test */
    public function rfc_management_page_can_be_rendered()
    {
        $this->login(null, true);

        $this->get('/admin/rfc')
            ->assertViewIs('rfc-admin')
            ->assertOk();
    }

    /** @test */
    public function create_rfc_screen_can_be_rendered()
    {
        $this->login(null, true);

        $this->get('/admin/rfc/new')
            ->assertViewIs('rfc-form')
            ->assertOk();
    }

    /** @test */
    public function create_rfc_returns_validation_errors()
    {
        $this->login(null, true);

        $this->post('/admin/rfc/new')
            ->assertSessionHasErrors(['title', 'description', 'url']);
    }

    /** @test */
    public function it_can_create_rfc()
    {
        $this->login(null, true);

        $this->post('/admin/rfc/new', [
            'title' => $this->faker->text(10),
            'description' => $this->faker->text(50),
            'url' => $this->faker->url
        ])
            ->assertRedirect();

        $this->assertDatabaseCount('rfcs', 1);
    }

    /** @test */
    public function edit_rfc_screen_can_be_rendered()
    {
        $this->withoutExceptionHandling();
        $rfc = Rfc::factory()->create();

        $this->login(null, true);

        $this->get("admin/rfc/{$rfc->id}")
            ->dd();
    }
}
