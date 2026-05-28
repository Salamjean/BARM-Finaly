<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Bilancompetence;
use App\Models\Candidature;

class BilancompetenceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bilancompetence::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->date(),
            'rapport' => $this->faker->word(),
            'comment' => $this->faker->text(),
            'candidature_id' => Candidature::factory(),
            'autor_id' => $this->faker->word(),
        ];
    }
}
