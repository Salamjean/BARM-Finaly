<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Entretien;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\EntretienController
 */
final class EntretienControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $entretiens = Entretien::factory()->count(3)->create();

        $response = $this->get(route('entretiens.index'));

        $response->assertOk();
        $response->assertViewIs('entretien.index');
        $response->assertViewHas('entretiens');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('entretiens.create'));

        $response->assertOk();
        $response->assertViewIs('entretien.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EntretienController::class,
            'store',
            \App\Http\Requests\EntretienStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $response = $this->post(route('entretiens.store'));

        $response->assertRedirect(route('entretiens.index'));
        $response->assertSessionHas('entretien.id', $entretien->id);

        $this->assertDatabaseHas(entretiens, [ /* ... */ ]);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $entretien = Entretien::factory()->create();

        $response = $this->get(route('entretiens.show', $entretien));

        $response->assertOk();
        $response->assertViewIs('entretien.show');
        $response->assertViewHas('entretien');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $entretien = Entretien::factory()->create();

        $response = $this->get(route('entretiens.edit', $entretien));

        $response->assertOk();
        $response->assertViewIs('entretien.edit');
        $response->assertViewHas('entretien');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EntretienController::class,
            'update',
            \App\Http\Requests\EntretienUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $entretien = Entretien::factory()->create();

        $response = $this->put(route('entretiens.update', $entretien));

        $entretien->refresh();

        $response->assertRedirect(route('entretiens.index'));
        $response->assertSessionHas('entretien.id', $entretien->id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $entretien = Entretien::factory()->create();

        $response = $this->delete(route('entretiens.destroy', $entretien));

        $response->assertRedirect(route('entretiens.index'));

        $this->assertModelMissing($entretien);
    }
}
