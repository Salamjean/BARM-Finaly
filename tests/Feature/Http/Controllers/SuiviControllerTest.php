<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Suivi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SuiviController
 */
final class SuiviControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $suivis = Suivi::factory()->count(3)->create();

        $response = $this->get(route('suivis.index'));

        $response->assertOk();
        $response->assertViewIs('suivi.index');
        $response->assertViewHas('suivis');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('suivis.create'));

        $response->assertOk();
        $response->assertViewIs('suivi.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SuiviController::class,
            'store',
            \App\Http\Requests\SuiviStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $response = $this->post(route('suivis.store'));

        $response->assertRedirect(route('suivis.index'));
        $response->assertSessionHas('suivi.id', $suivi->id);

        $this->assertDatabaseHas(suivis, [ /* ... */ ]);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $suivi = Suivi::factory()->create();

        $response = $this->get(route('suivis.show', $suivi));

        $response->assertOk();
        $response->assertViewIs('suivi.show');
        $response->assertViewHas('suivi');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $suivi = Suivi::factory()->create();

        $response = $this->get(route('suivis.edit', $suivi));

        $response->assertOk();
        $response->assertViewIs('suivi.edit');
        $response->assertViewHas('suivi');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SuiviController::class,
            'update',
            \App\Http\Requests\SuiviUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $suivi = Suivi::factory()->create();

        $response = $this->put(route('suivis.update', $suivi));

        $suivi->refresh();

        $response->assertRedirect(route('suivis.index'));
        $response->assertSessionHas('suivi.id', $suivi->id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $suivi = Suivi::factory()->create();

        $response = $this->delete(route('suivis.destroy', $suivi));

        $response->assertRedirect(route('suivis.index'));

        $this->assertModelMissing($suivi);
    }
}
