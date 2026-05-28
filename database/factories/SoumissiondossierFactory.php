<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Soumissiondossier;

class SoumissiondossierFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Soumissiondossier::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'candidature_id' => $this->faker->word(),
            'intitule_concours' => $this->faker->word(),
            'type_concours' => $this->faker->word(),
            'autor_id' => $this->faker->word(),
        ];
    }
}
