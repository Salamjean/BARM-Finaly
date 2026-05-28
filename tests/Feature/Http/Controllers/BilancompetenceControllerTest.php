<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Bilancompetence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\BilancompetenceController
 */
final class BilancompetenceControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $bilancompetences = Bilancompetence::factory()->count(3)->create();

        $response = $this->get(route('bilancompetences.index'));

        $response->assertOk();
        $response->assertViewIs('bilancompetence.index');
        $response->assertViewHas('bilancompetences');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('bilancompetences.create'));

        $response->assertOk();
        $response->assertViewIs('bilancompetence.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\BilancompetenceController::class,
            'store',
            \App\Http\Requests\BilancompetenceStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $response = $this->post(route('bilancompetences.store'));

        $response->assertRedirect(route('bilancompetences.index'));
        $response->assertSessionHas('bilancompetence.id', $bilancompetence->id);

        $this->assertDatabaseHas(bilancompetences, [ /* ... */ ]);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $bilancompetence = Bilancompetence::factory()->create();

        $response = $this->get(route('bilancompetences.show', $bilancompetence));

        $response->assertOk();
        $response->assertViewIs('bilancompetence.show');
        $response->assertViewHas('bilancompetence');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $bilancompetence = Bilancompetence::factory()->create();

        $response = $this->get(route('bilancompetences.edit', $bilancompetence));

        $response->assertOk();
        $response->assertViewIs('bilancompetence.edit');
        $response->assertViewHas('bilancompetence');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\BilancompetenceController::class,
            'update',
            \App\Http\Requests\BilancompetenceUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $bilancompetence = Bilancompetence::factory()->create();

        $response = $this->put(route('bilancompetences.update', $bilancompetence));

        $bilancompetence->refresh();

        $response->assertRedirect(route('bilancompetences.index'));
        $response->assertSessionHas('bilancompetence.id', $bilancompetence->id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $bilancompetence = Bilancompetence::factory()->create();

        $response = $this->delete(route('bilancompetences.destroy', $bilancompetence));

        $response->assertRedirect(route('bilancompetences.index'));

        $this->assertModelMissing($bilancompetence);
    }
}
