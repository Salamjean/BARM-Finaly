<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Budgetitem;
use App\Models\Budgetsection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\BudgetitemController
 */
final class BudgetitemControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $budgetitems = Budgetitem::factory()->count(3)->create();

        $response = $this->get(route('budgetitems.index'));

        $response->assertOk();
        $response->assertViewIs('budgetitem.index');
        $response->assertViewHas('budgetitems');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('budgetitems.create'));

        $response->assertOk();
        $response->assertViewIs('budgetitem.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\BudgetitemController::class,
            'store',
            \App\Http\Requests\BudgetitemStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $budgetsection = Budgetsection::factory()->create();

        $response = $this->post(route('budgetitems.store'), [
            'budgetsection_id' => $budgetsection->id,
        ]);

        $budgetitems = Budgetitem::query()
            ->where('budgetsection_id', $budgetsection->id)
            ->get();
        $this->assertCount(1, $budgetitems);
        $budgetitem = $budgetitems->first();

        $response->assertRedirect(route('budgetitems.index'));
        $response->assertSessionHas('budgetitem.id', $budgetitem->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $budgetitem = Budgetitem::factory()->create();

        $response = $this->get(route('budgetitems.show', $budgetitem));

        $response->assertOk();
        $response->assertViewIs('budgetitem.show');
        $response->assertViewHas('budgetitem');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $budgetitem = Budgetitem::factory()->create();

        $response = $this->get(route('budgetitems.edit', $budgetitem));

        $response->assertOk();
        $response->assertViewIs('budgetitem.edit');
        $response->assertViewHas('budgetitem');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\BudgetitemController::class,
            'update',
            \App\Http\Requests\BudgetitemUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $budgetitem = Budgetitem::factory()->create();
        $budgetsection = Budgetsection::factory()->create();

        $response = $this->put(route('budgetitems.update', $budgetitem), [
            'budgetsection_id' => $budgetsection->id,
        ]);

        $budgetitem->refresh();

        $response->assertRedirect(route('budgetitems.index'));
        $response->assertSessionHas('budgetitem.id', $budgetitem->id);

        $this->assertEquals($budgetsection->id, $budgetitem->budgetsection_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $budgetitem = Budgetitem::factory()->create();

        $response = $this->delete(route('budgetitems.destroy', $budgetitem));

        $response->assertRedirect(route('budgetitems.index'));

        $this->assertModelMissing($budgetitem);
    }
}
