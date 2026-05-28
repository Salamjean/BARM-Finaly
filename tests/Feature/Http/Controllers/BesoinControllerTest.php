<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Besoin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\BesoinController
 */
final class BesoinControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $besoins = Besoin::factory()->count(3)->create();

        $response = $this->get(route('besoins.index'));

        $response->assertOk();
        $response->assertViewIs('besoin.index');
        $response->assertViewHas('besoins');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('besoins.create'));

        $response->assertOk();
        $response->assertViewIs('besoin.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\BesoinController::class,
            'store',
            \App\Http\Requests\BesoinStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $status = $this->faker->randomElement(/** enum_attributes **/);

        $response = $this->post(route('besoins.store'), [
            'status' => $status,
        ]);

        $besoins = Besoin::query()
            ->where('status', $status)
            ->get();
        $this->assertCount(1, $besoins);
        $besoin = $besoins->first();

        $response->assertRedirect(route('besoins.index'));
        $response->assertSessionHas('besoin.id', $besoin->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $besoin = Besoin::factory()->create();

        $response = $this->get(route('besoins.show', $besoin));

        $response->assertOk();
        $response->assertViewIs('besoin.show');
        $response->assertViewHas('besoin');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $besoin = Besoin::factory()->create();

        $response = $this->get(route('besoins.edit', $besoin));

        $response->assertOk();
        $response->assertViewIs('besoin.edit');
        $response->assertViewHas('besoin');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\BesoinController::class,
            'update',
            \App\Http\Requests\BesoinUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $besoin = Besoin::factory()->create();
        $status = $this->faker->randomElement(/** enum_attributes **/);

        $response = $this->put(route('besoins.update', $besoin), [
            'status' => $status,
        ]);

        $besoin->refresh();

        $response->assertRedirect(route('besoins.index'));
        $response->assertSessionHas('besoin.id', $besoin->id);

        $this->assertEquals($status, $besoin->status);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $besoin = Besoin::factory()->create();

        $response = $this->delete(route('besoins.destroy', $besoin));

        $response->assertRedirect(route('besoins.index'));

        $this->assertModelMissing($besoin);
    }
}
