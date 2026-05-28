<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Entreprise;

class EntrepriseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Entreprise::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nom' => $this->faker->word(),
            'localisation' => $this->faker->word(),
            'specialisation' => $this->faker->word(),
            'num_decharge' => $this->faker->word(),
            'nom_point_focal' => $this->faker->word(),
            'email_point_focal' => $this->faker->word(),
            'type' => $this->faker->word(),
            'autor_id' => $this->faker->word(),
        ];
    }
}
