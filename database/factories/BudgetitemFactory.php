<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Budgetitem;
use App\Models\Budgetservice;

class BudgetitemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Budgetitem::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'ressource' => $this->faker->word(),
            'montant_vote' => $this->faker->word(),
            'montant_recu' => $this->faker->word(),
            'budgetsection_id' => Budgetservice::factory(),
        ];
    }
}
