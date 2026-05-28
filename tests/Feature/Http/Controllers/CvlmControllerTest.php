<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Cvlm;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CvlmController
 */
final class CvlmControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $cvlms = Cvlm::factory()->count(3)->create();

        $response = $this->get(route('cvlms.index'));

        $response->assertOk();
        $response->assertViewIs('cvlm.index');
        $response->assertViewHas('cvlms');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('cvlms.create'));

        $response->assertOk();
        $response->assertViewIs('cvlm.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CvlmController::class,
            'store',
            \App\Http\Requests\CvlmStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $response = $this->post(route('cvlms.store'));

        $response->assertRedirect(route('cvlms.index'));
        $response->assertSessionHas('cvlm.id', $cvlm->id);

        $this->assertDatabaseHas(cvlms, [ /* ... */ ]);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $cvlm = Cvlm::factory()->create();

        $response = $this->get(route('cvlms.show', $cvlm));

        $response->assertOk();
        $response->assertViewIs('cvlm.show');
        $response->assertViewHas('cvlm');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $cvlm = Cvlm::factory()->create();

        $response = $this->get(route('cvlms.edit', $cvlm));

        $response->assertOk();
        $response->assertViewIs('cvlm.edit');
        $response->assertViewHas('cvlm');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CvlmController::class,
            'update',
            \App\Http\Requests\CvlmUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $cvlm = Cvlm::factory()->create();

        $response = $this->put(route('cvlms.update', $cvlm));

        $cvlm->refresh();

        $response->assertRedirect(route('cvlms.index'));
        $response->assertSessionHas('cvlm.id', $cvlm->id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $cvlm = Cvlm::factory()->create();

        $response = $this->delete(route('cvlms.destroy', $cvlm));

        $response->assertRedirect(route('cvlms.index'));

        $this->assertModelMissing($cvlm);
    }
}
