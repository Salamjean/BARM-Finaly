<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Choixconcour;
use App\Models\Choixconcours;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ChoixconcoursController
 */
final class ChoixconcoursControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $choixconcours = Choixconcours::factory()->count(3)->create();

        $response = $this->get(route('choixconcours.index'));

        $response->assertOk();
        $response->assertViewIs('choixconcour.index');
        $response->assertViewHas('choixconcours');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('choixconcours.create'));

        $response->assertOk();
        $response->assertViewIs('choixconcour.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ChoixconcoursController::class,
            'store',
            \App\Http\Requests\ChoixconcoursStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $response = $this->post(route('choixconcours.store'));

        $response->assertRedirect(route('choixconcours.index'));
        $response->assertSessionHas('choixconcour.id', $choixconcour->id);

        $this->assertDatabaseHas(choixconcours, [ /* ... */ ]);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $choixconcour = Choixconcours::factory()->create();

        $response = $this->get(route('choixconcours.show', $choixconcour));

        $response->assertOk();
        $response->assertViewIs('choixconcour.show');
        $response->assertViewHas('choixconcour');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $choixconcour = Choixconcours::factory()->create();

        $response = $this->get(route('choixconcours.edit', $choixconcour));

        $response->assertOk();
        $response->assertViewIs('choixconcour.edit');
        $response->assertViewHas('choixconcour');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ChoixconcoursController::class,
            'update',
            \App\Http\Requests\ChoixconcoursUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $choixconcour = Choixconcours::factory()->create();

        $response = $this->put(route('choixconcours.update', $choixconcour));

        $choixconcour->refresh();

        $response->assertRedirect(route('choixconcours.index'));
        $response->assertSessionHas('choixconcour.id', $choixconcour->id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $choixconcour = Choixconcours::factory()->create();
        $choixconcour = Choixconcour::factory()->create();

        $response = $this->delete(route('choixconcours.destroy', $choixconcour));

        $response->assertRedirect(route('choixconcours.index'));

        $this->assertModelMissing($choixconcour);
    }
}
