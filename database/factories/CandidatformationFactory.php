<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Candidatformation;

class CandidatformationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Candidatformation::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'candidature_id' => $this->faker->word(),
            'formation_id' => $this->faker->word(),
            'presence' => $this->faker->randomElement(["0","1"]),
            'commentaire' => $this->faker->text(),
            'attestation' => $this->faker->word(),
            'autor_id' => $this->faker->word(),
        ];
    }
}
