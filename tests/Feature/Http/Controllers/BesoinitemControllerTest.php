<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Besoinitem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\BesoinitemController
 */
final class BesoinitemControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $besoinitems = Besoinitem::factory()->count(3)->create();

        $response = $this->get(route('besoinitems.index'));

        $response->assertOk();
        $response->assertViewIs('besoinitem.index');
        $response->assertViewHas('besoinitems');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('besoinitems.create'));

        $response->assertOk();
        $response->assertViewIs('besoinitem.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\BesoinitemController::class,
            'store',
            \App\Http\Requests\BesoinitemStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $response = $this->post(route('besoinitems.store'));

        $response->assertRedirect(route('besoinitems.index'));
        $response->assertSessionHas('besoinitem.id', $besoinitem->id);

        $this->assertDatabaseHas(besoinitems, [ /* ... */ ]);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $besoinitem = Besoinitem::factory()->create();

        $response = $this->get(route('besoinitems.show', $besoinitem));

        $response->assertOk();
        $response->assertViewIs('besoinitem.show');
        $response->assertViewHas('besoinitem');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $besoinitem = Besoinitem::factory()->create();

        $response = $this->get(route('besoinitems.edit', $besoinitem));

        $response->assertOk();
        $response->assertViewIs('besoinitem.edit');
        $response->assertViewHas('besoinitem');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\BesoinitemController::class,
            'update',
            \App\Http\Requests\BesoinitemUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $besoinitem = Besoinitem::factory()->create();

        $response = $this->put(route('besoinitems.update', $besoinitem));

        $besoinitem->refresh();

        $response->assertRedirect(route('besoinitems.index'));
        $response->assertSessionHas('besoinitem.id', $besoinitem->id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $besoinitem = Besoinitem::factory()->create();

        $response = $this->delete(route('besoinitems.destroy', $besoinitem));

        $response->assertRedirect(route('besoinitems.index'));

        $this->assertModelMissing($besoinitem);
    }
}
