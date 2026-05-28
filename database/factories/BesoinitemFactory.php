<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Besoin;
use App\Models\Besoinitem;

class BesoinitemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Besoinitem::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'designation' => $this->faker->word(),
            'qte_demande' => $this->faker->word(),
            'qte_recue' => $this->faker->word(),
            'qte_manquante' => $this->faker->word(),
            'besoin_id' => Besoin::factory(),
        ];
    }
}
