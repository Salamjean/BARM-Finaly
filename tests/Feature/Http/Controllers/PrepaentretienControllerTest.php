<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Prepaentretien;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PrepaentretienController
 */
final class PrepaentretienControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $prepaentretiens = Prepaentretien::factory()->count(3)->create();

        $response = $this->get(route('prepaentretiens.index'));

        $response->assertOk();
        $response->assertViewIs('prepaentretien.index');
        $response->assertViewHas('prepaentretiens');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('prepaentretiens.create'));

        $response->assertOk();
        $response->assertViewIs('prepaentretien.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PrepaentretienController::class,
            'store',
            \App\Http\Requests\PrepaentretienStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $response = $this->post(route('prepaentretiens.store'));

        $response->assertRedirect(route('prepaentretiens.index'));
        $response->assertSessionHas('prepaentretien.id', $prepaentretien->id);

        $this->assertDatabaseHas(prepaentretiens, [ /* ... */ ]);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $prepaentretien = Prepaentretien::factory()->create();

        $response = $this->get(route('prepaentretiens.show', $prepaentretien));

        $response->assertOk();
        $response->assertViewIs('prepaentretien.show');
        $response->assertViewHas('prepaentretien');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $prepaentretien = Prepaentretien::factory()->create();

        $response = $this->get(route('prepaentretiens.edit', $prepaentretien));

        $response->assertOk();
        $response->assertViewIs('prepaentretien.edit');
        $response->assertViewHas('prepaentretien');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PrepaentretienController::class,
            'update',
            \App\Http\Requests\PrepaentretienUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $prepaentretien = Prepaentretien::factory()->create();

        $response = $this->put(route('prepaentretiens.update', $prepaentretien));

        $prepaentretien->refresh();

        $response->assertRedirect(route('prepaentretiens.index'));
        $response->assertSessionHas('prepaentretien.id', $prepaentretien->id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $prepaentretien = Prepaentretien::factory()->create();

        $response = $this->delete(route('prepaentretiens.destroy', $prepaentretien));

        $response->assertRedirect(route('prepaentretiens.index'));

        $this->assertModelMissing($prepaentretien);
    }
}
