<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Budget;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\BudgetController
 */
final class BudgetControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $budgets = Budget::factory()->count(3)->create();

        $response = $this->get(route('budgets.index'));

        $response->assertOk();
        $response->assertViewIs('budget.index');
        $response->assertViewHas('budgets');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('budgets.create'));

        $response->assertOk();
        $response->assertViewIs('budget.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\BudgetController::class,
            'store',
            \App\Http\Requests\BudgetStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $status = $this->faker->randomElement(/** enum_attributes **/);

        $response = $this->post(route('budgets.store'), [
            'status' => $status,
        ]);

        $budgets = Budget::query()
            ->where('status', $status)
            ->get();
        $this->assertCount(1, $budgets);
        $budget = $budgets->first();

        $response->assertRedirect(route('budgets.index'));
        $response->assertSessionHas('budget.id', $budget->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $budget = Budget::factory()->create();

        $response = $this->get(route('budgets.show', $budget));

        $response->assertOk();
        $response->assertViewIs('budget.show');
        $response->assertViewHas('budget');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $budget = Budget::factory()->create();

        $response = $this->get(route('budgets.edit', $budget));

        $response->assertOk();
        $response->assertViewIs('budget.edit');
        $response->assertViewHas('budget');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\BudgetController::class,
            'update',
            \App\Http\Requests\BudgetUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $budget = Budget::factory()->create();
        $status = $this->faker->randomElement(/** enum_attributes **/);

        $response = $this->put(route('budgets.update', $budget), [
            'status' => $status,
        ]);

        $budget->refresh();

        $response->assertRedirect(route('budgets.index'));
        $response->assertSessionHas('budget.id', $budget->id);

        $this->assertEquals($status, $budget->status);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $budget = Budget::factory()->create();

        $response = $this->delete(route('budgets.destroy', $budget));

        $response->assertRedirect(route('budgets.index'));

        $this->assertModelMissing($budget);
    }
}
