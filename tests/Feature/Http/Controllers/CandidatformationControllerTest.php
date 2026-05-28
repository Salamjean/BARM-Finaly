<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Candidatformation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CandidatformationController
 */
final class CandidatformationControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $candidatformations = Candidatformation::factory()->count(3)->create();

        $response = $this->get(route('candidatformations.index'));

        $response->assertOk();
        $response->assertViewIs('candidatformation.index');
        $response->assertViewHas('candidatformations');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('candidatformations.create'));

        $response->assertOk();
        $response->assertViewIs('candidatformation.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CandidatformationController::class,
            'store',
            \App\Http\Requests\CandidatformationStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $response = $this->post(route('candidatformations.store'));

        $response->assertRedirect(route('candidatformations.index'));
        $response->assertSessionHas('candidatformation.id', $candidatformation->id);

        $this->assertDatabaseHas(candidatformations, [ /* ... */ ]);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $candidatformation = Candidatformation::factory()->create();

        $response = $this->get(route('candidatformations.show', $candidatformation));

        $response->assertOk();
        $response->assertViewIs('candidatformation.show');
        $response->assertViewHas('candidatformation');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $candidatformation = Candidatformation::factory()->create();

        $response = $this->get(route('candidatformations.edit', $candidatformation));

        $response->assertOk();
        $response->assertViewIs('candidatformation.edit');
        $response->assertViewHas('candidatformation');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CandidatformationController::class,
            'update',
            \App\Http\Requests\CandidatformationUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $candidatformation = Candidatformation::factory()->create();

        $response = $this->put(route('candidatformations.update', $candidatformation));

        $candidatformation->refresh();

        $response->assertRedirect(route('candidatformations.index'));
        $response->assertSessionHas('candidatformation.id', $candidatformation->id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $candidatformation = Candidatformation::factory()->create();

        $response = $this->delete(route('candidatformations.destroy', $candidatformation));

        $response->assertRedirect(route('candidatformations.index'));

        $this->assertModelMissing($candidatformation);
    }
}
