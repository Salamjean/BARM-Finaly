<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ServiceController
 */
final class ServiceControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $services = Service::factory()->count(3)->create();

        $response = $this->get(route('services.index'));

        $response->assertOk();
        $response->assertViewIs('service.index');
        $response->assertViewHas('services');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('services.create'));

        $response->assertOk();
        $response->assertViewIs('service.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ServiceController::class,
            'store',
            \App\Http\Requests\ServiceStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $response = $this->post(route('services.store'));

        $response->assertRedirect(route('services.index'));
        $response->assertSessionHas('service.id', $service->id);

        $this->assertDatabaseHas(services, [ /* ... */ ]);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $service = Service::factory()->create();

        $response = $this->get(route('services.show', $service));

        $response->assertOk();
        $response->assertViewIs('service.show');
        $response->assertViewHas('service');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $service = Service::factory()->create();

        $response = $this->get(route('services.edit', $service));

        $response->assertOk();
        $response->assertViewIs('service.edit');
        $response->assertViewHas('service');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ServiceController::class,
            'update',
            \App\Http\Requests\ServiceUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $service = Service::factory()->create();

        $response = $this->put(route('services.update', $service));

        $service->refresh();

        $response->assertRedirect(route('services.index'));
        $response->assertSessionHas('service.id', $service->id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $service = Service::factory()->create();

        $response = $this->delete(route('services.destroy', $service));

        $response->assertRedirect(route('services.index'));

        $this->assertModelMissing($service);
    }
}
