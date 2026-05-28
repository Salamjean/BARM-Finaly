<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Formation;

class FormationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Formation::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'entreprise_id' => $this->faker->word(),
            'intitule' => $this->faker->word(),
            'date_db' => $this->faker->date(),
            'date_fin' => $this->faker->date(),
            'lieu' => $this->faker->word(),
            'autor_id' => $this->faker->word(),
        ];
    }
}
