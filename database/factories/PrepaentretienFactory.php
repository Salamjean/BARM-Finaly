<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Prepaentretien;

class PrepaentretienFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Prepaentretien::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'candidature_id' => $this->faker->word(),
            'presence' => $this->faker->randomElement(["0","1"]),
            'date' => $this->faker->date(),
            'commentaire' => $this->faker->text(),
        ];
    }
}
