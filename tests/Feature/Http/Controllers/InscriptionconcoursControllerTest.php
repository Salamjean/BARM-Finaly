<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Inscriptionconcour;
use App\Models\Inscriptionconcours;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\InscriptionconcoursController
 */
final class InscriptionconcoursControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $inscriptionconcours = Inscriptionconcours::factory()->count(3)->create();

        $response = $this->get(route('inscriptionconcours.index'));

        $response->assertOk();
        $response->assertViewIs('inscriptionconcour.index');
        $response->assertViewHas('inscriptionconcours');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('inscriptionconcours.create'));

        $response->assertOk();
        $response->assertViewIs('inscriptionconcour.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\InscriptionconcoursController::class,
            'store',
            \App\Http\Requests\InscriptionconcoursStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $response = $this->post(route('inscriptionconcours.store'));

        $response->assertRedirect(route('inscriptionconcours.index'));
        $response->assertSessionHas('inscriptionconcour.id', $inscriptionconcour->id);

        $this->assertDatabaseHas(inscriptionconcours, [ /* ... */ ]);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $inscriptionconcour = Inscriptionconcours::factory()->create();

        $response = $this->get(route('inscriptionconcours.show', $inscriptionconcour));

        $response->assertOk();
        $response->assertViewIs('inscriptionconcour.show');
        $response->assertViewHas('inscriptionconcour');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $inscriptionconcour = Inscriptionconcours::factory()->create();

        $response = $this->get(route('inscriptionconcours.edit', $inscriptionconcour));

        $response->assertOk();
        $response->assertViewIs('inscriptionconcour.edit');
        $response->assertViewHas('inscriptionconcour');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\InscriptionconcoursController::class,
            'update',
            \App\Http\Requests\InscriptionconcoursUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $inscriptionconcour = Inscriptionconcours::factory()->create();

        $response = $this->put(route('inscriptionconcours.update', $inscriptionconcour));

        $inscriptionconcour->refresh();

        $response->assertRedirect(route('inscriptionconcours.index'));
        $response->assertSessionHas('inscriptionconcour.id', $inscriptionconcour->id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $inscriptionconcour = Inscriptionconcours::factory()->create();
        $inscriptionconcour = Inscriptionconcour::factory()->create();

        $response = $this->delete(route('inscriptionconcours.destroy', $inscriptionconcour));

        $response->assertRedirect(route('inscriptionconcours.index'));

        $this->assertModelMissing($inscriptionconcour);
    }
}
