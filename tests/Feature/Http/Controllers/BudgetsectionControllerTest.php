<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Budgetsection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\BudgetsectionController
 */
final class BudgetsectionControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $budgetsections = Budgetsection::factory()->count(3)->create();

        $response = $this->get(route('budgetsections.index'));

        $response->assertOk();
        $response->assertViewIs('budgetsection.index');
        $response->assertViewHas('budgetsections');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('budgetsections.create'));

        $response->assertOk();
        $response->assertViewIs('budgetsection.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\BudgetsectionController::class,
            'store',
            \App\Http\Requests\BudgetsectionStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $response = $this->post(route('budgetsections.store'));

        $response->assertRedirect(route('budgetsections.index'));
        $response->assertSessionHas('budgetsection.id', $budgetsection->id);

        $this->assertDatabaseHas(budgetsections, [ /* ... */ ]);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $budgetsection = Budgetsection::factory()->create();

        $response = $this->get(route('budgetsections.show', $budgetsection));

        $response->assertOk();
        $response->assertViewIs('budgetsection.show');
        $response->assertViewHas('budgetsection');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $budgetsection = Budgetsection::factory()->create();

        $response = $this->get(route('budgetsections.edit', $budgetsection));

        $response->assertOk();
        $response->assertViewIs('budgetsection.edit');
        $response->assertViewHas('budgetsection');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\BudgetsectionController::class,
            'update',
            \App\Http\Requests\BudgetsectionUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $budgetsection = Budgetsection::factory()->create();

        $response = $this->put(route('budgetsections.update', $budgetsection));

        $budgetsection->refresh();

        $response->assertRedirect(route('budgetsections.index'));
        $response->assertSessionHas('budgetsection.id', $budgetsection->id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $budgetsection = Budgetsection::factory()->create();

        $response = $this->delete(route('budgetsections.destroy', $budgetsection));

        $response->assertRedirect(route('budgetsections.index'));

        $this->assertModelMissing($budgetsection);
    }
}
