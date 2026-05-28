<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Formation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\FormationController
 */
final class FormationControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $formations = Formation::factory()->count(3)->create();

        $response = $this->get(route('formations.index'));

        $response->assertOk();
        $response->assertViewIs('formation.index');
        $response->assertViewHas('formations');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('formations.create'));

        $response->assertOk();
        $response->assertViewIs('formation.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\FormationController::class,
            'store',
            \App\Http\Requests\FormationStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $response = $this->post(route('formations.store'));

        $response->assertRedirect(route('formations.index'));
        $response->assertSessionHas('formation.id', $formation->id);

        $this->assertDatabaseHas(formations, [ /* ... */ ]);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $formation = Formation::factory()->create();

        $response = $this->get(route('formations.show', $formation));

        $response->assertOk();
        $response->assertViewIs('formation.show');
        $response->assertViewHas('formation');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $formation = Formation::factory()->create();

        $response = $this->get(route('formations.edit', $formation));

        $response->assertOk();
        $response->assertViewIs('formation.edit');
        $response->assertViewHas('formation');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\FormationController::class,
            'update',
            \App\Http\Requests\FormationUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $formation = Formation::factory()->create();

        $response = $this->put(route('formations.update', $formation));

        $formation->refresh();

        $response->assertRedirect(route('formations.index'));
        $response->assertSessionHas('formation.id', $formation->id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $formation = Formation::factory()->create();

        $response = $this->delete(route('formations.destroy', $formation));

        $response->assertRedirect(route('formations.index'));

        $this->assertModelMissing($formation);
    }
}
