<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Soumissiondossier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SoumissiondossierController
 */
final class SoumissiondossierControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $soumissiondossiers = Soumissiondossier::factory()->count(3)->create();

        $response = $this->get(route('soumissiondossiers.index'));

        $response->assertOk();
        $response->assertViewIs('soumissiondossier.index');
        $response->assertViewHas('soumissiondossiers');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('soumissiondossiers.create'));

        $response->assertOk();
        $response->assertViewIs('soumissiondossier.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SoumissiondossierController::class,
            'store',
            \App\Http\Requests\SoumissiondossierStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $response = $this->post(route('soumissiondossiers.store'));

        $response->assertRedirect(route('soumissiondossiers.index'));
        $response->assertSessionHas('soumissiondossier.id', $soumissiondossier->id);

        $this->assertDatabaseHas(soumissiondossiers, [ /* ... */ ]);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $soumissiondossier = Soumissiondossier::factory()->create();

        $response = $this->get(route('soumissiondossiers.show', $soumissiondossier));

        $response->assertOk();
        $response->assertViewIs('soumissiondossier.show');
        $response->assertViewHas('soumissiondossier');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $soumissiondossier = Soumissiondossier::factory()->create();

        $response = $this->get(route('soumissiondossiers.edit', $soumissiondossier));

        $response->assertOk();
        $response->assertViewIs('soumissiondossier.edit');
        $response->assertViewHas('soumissiondossier');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SoumissiondossierController::class,
            'update',
            \App\Http\Requests\SoumissiondossierUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $soumissiondossier = Soumissiondossier::factory()->create();

        $response = $this->put(route('soumissiondossiers.update', $soumissiondossier));

        $soumissiondossier->refresh();

        $response->assertRedirect(route('soumissiondossiers.index'));
        $response->assertSessionHas('soumissiondossier.id', $soumissiondossier->id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $soumissiondossier = Soumissiondossier::factory()->create();

        $response = $this->delete(route('soumissiondossiers.destroy', $soumissiondossier));

        $response->assertRedirect(route('soumissiondossiers.index'));

        $this->assertModelMissing($soumissiondossier);
    }
}
