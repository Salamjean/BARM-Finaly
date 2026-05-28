<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Entreprise;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\EntrepriseController
 */
final class EntrepriseControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $entreprises = Entreprise::factory()->count(3)->create();

        $response = $this->get(route('entreprises.index'));

        $response->assertOk();
        $response->assertViewIs('entreprise.index');
        $response->assertViewHas('entreprises');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('entreprises.create'));

        $response->assertOk();
        $response->assertViewIs('entreprise.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EntrepriseController::class,
            'store',
            \App\Http\Requests\EntrepriseStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $response = $this->post(route('entreprises.store'));

        $response->assertRedirect(route('entreprises.index'));
        $response->assertSessionHas('entreprise.id', $entreprise->id);

        $this->assertDatabaseHas(entreprises, [ /* ... */ ]);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $entreprise = Entreprise::factory()->create();

        $response = $this->get(route('entreprises.show', $entreprise));

        $response->assertOk();
        $response->assertViewIs('entreprise.show');
        $response->assertViewHas('entreprise');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $entreprise = Entreprise::factory()->create();

        $response = $this->get(route('entreprises.edit', $entreprise));

        $response->assertOk();
        $response->assertViewIs('entreprise.edit');
        $response->assertViewHas('entreprise');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EntrepriseController::class,
            'update',
            \App\Http\Requests\EntrepriseUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $entreprise = Entreprise::factory()->create();

        $response = $this->put(route('entreprises.update', $entreprise));

        $entreprise->refresh();

        $response->assertRedirect(route('entreprises.index'));
        $response->assertSessionHas('entreprise.id', $entreprise->id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $entreprise = Entreprise::factory()->create();

        $response = $this->delete(route('entreprises.destroy', $entreprise));

        $response->assertRedirect(route('entreprises.index'));

        $this->assertModelMissing($entreprise);
    }
}
