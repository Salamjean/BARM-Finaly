<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Candidatsadmi;
use App\Models\Candidatsadmis;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CandidatsadmisController
 */
final class CandidatsadmisControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $candidatsadmis = Candidatsadmis::factory()->count(3)->create();

        $response = $this->get(route('candidatsadmis.index'));

        $response->assertOk();
        $response->assertViewIs('candidatsadmi.index');
        $response->assertViewHas('candidatsadmis');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('candidatsadmis.create'));

        $response->assertOk();
        $response->assertViewIs('candidatsadmi.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CandidatsadmisController::class,
            'store',
            \App\Http\Requests\CandidatsadmisStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $response = $this->post(route('candidatsadmis.store'));

        $response->assertRedirect(route('candidatsadmis.index'));
        $response->assertSessionHas('candidatsadmi.id', $candidatsadmi->id);

        $this->assertDatabaseHas(candidatsadmis, [ /* ... */ ]);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $candidatsadmi = Candidatsadmis::factory()->create();

        $response = $this->get(route('candidatsadmis.show', $candidatsadmi));

        $response->assertOk();
        $response->assertViewIs('candidatsadmi.show');
        $response->assertViewHas('candidatsadmi');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $candidatsadmi = Candidatsadmis::factory()->create();

        $response = $this->get(route('candidatsadmis.edit', $candidatsadmi));

        $response->assertOk();
        $response->assertViewIs('candidatsadmi.edit');
        $response->assertViewHas('candidatsadmi');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CandidatsadmisController::class,
            'update',
            \App\Http\Requests\CandidatsadmisUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $candidatsadmi = Candidatsadmis::factory()->create();

        $response = $this->put(route('candidatsadmis.update', $candidatsadmi));

        $candidatsadmi->refresh();

        $response->assertRedirect(route('candidatsadmis.index'));
        $response->assertSessionHas('candidatsadmi.id', $candidatsadmi->id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $candidatsadmi = Candidatsadmis::factory()->create();
        $candidatsadmi = Candidatsadmi::factory()->create();

        $response = $this->delete(route('candidatsadmis.destroy', $candidatsadmi));

        $response->assertRedirect(route('candidatsadmis.index'));

        $this->assertModelMissing($candidatsadmi);
    }
}
