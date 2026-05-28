<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Candidatentreprise;

class CandidatentrepriseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Candidatentreprise::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'candidature_id' => $this->faker->word(),
            'entreprise_id' => $this->faker->word(),
            'date_mise_disposition' => $this->faker->date(),
            'statut' => $this->faker->randomElement(["pending","accepted","refused","finished","on_hold"]),
            'poste' => $this->faker->word(),
            'type_contrat' => $this->faker->word(),
            'date_db' => $this->faker->date(),
            'date_fin' => $this->faker->date(),
            'contrat' => $this->faker->word(),
            'localisation' => $this->faker->word(),
            'commentaire' => $this->faker->text(),
        ];
    }
}
