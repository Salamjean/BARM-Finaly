<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Candidatentreprise;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CandidatentrepriseController
 */
final class CandidatentrepriseControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $candidatentreprises = Candidatentreprise::factory()->count(3)->create();

        $response = $this->get(route('candidatentreprises.index'));

        $response->assertOk();
        $response->assertViewIs('candidatentreprise.index');
        $response->assertViewHas('candidatentreprises');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('candidatentreprises.create'));

        $response->assertOk();
        $response->assertViewIs('candidatentreprise.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CandidatentrepriseController::class,
            'store',
            \App\Http\Requests\CandidatentrepriseStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $statut = $this->faker->randomElement(/** enum_attributes **/);

        $response = $this->post(route('candidatentreprises.store'), [
            'statut' => $statut,
        ]);

        $candidatentreprises = Candidatentreprise::query()
            ->where('statut', $statut)
            ->get();
        $this->assertCount(1, $candidatentreprises);
        $candidatentreprise = $candidatentreprises->first();

        $response->assertRedirect(route('candidatentreprises.index'));
        $response->assertSessionHas('candidatentreprise.id', $candidatentreprise->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $candidatentreprise = Candidatentreprise::factory()->create();

        $response = $this->get(route('candidatentreprises.show', $candidatentreprise));

        $response->assertOk();
        $response->assertViewIs('candidatentreprise.show');
        $response->assertViewHas('candidatentreprise');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $candidatentreprise = Candidatentreprise::factory()->create();

        $response = $this->get(route('candidatentreprises.edit', $candidatentreprise));

        $response->assertOk();
        $response->assertViewIs('candidatentreprise.edit');
        $response->assertViewHas('candidatentreprise');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CandidatentrepriseController::class,
            'update',
            \App\Http\Requests\CandidatentrepriseUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $candidatentreprise = Candidatentreprise::factory()->create();
        $statut = $this->faker->randomElement(/** enum_attributes **/);

        $response = $this->put(route('candidatentreprises.update', $candidatentreprise), [
            'statut' => $statut,
        ]);

        $candidatentreprise->refresh();

        $response->assertRedirect(route('candidatentreprises.index'));
        $response->assertSessionHas('candidatentreprise.id', $candidatentreprise->id);

        $this->assertEquals($statut, $candidatentreprise->statut);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $candidatentreprise = Candidatentreprise::factory()->create();

        $response = $this->delete(route('candidatentreprises.destroy', $candidatentreprise));

        $response->assertRedirect(route('candidatentreprises.index'));

        $this->assertModelMissing($candidatentreprise);
    }
}
