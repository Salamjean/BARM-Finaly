<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Suivi;

class SuiviFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Suivi::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'candidatentreprise_id' => $this->faker->word(),
            'candidature_id' => $this->faker->word(),
            'entreprise_id' => $this->faker->word(),
            'intitule' => $this->faker->word(),
            'date' => $this->faker->date(),
            'commentaire' => $this->faker->text(),
            'rapport' => $this->faker->word(),
        ];
    }
}
