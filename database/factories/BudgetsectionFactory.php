<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Budget;
use App\Models\Budgetsection;

class BudgetsectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Budgetsection::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'titre' => $this->faker->word(),
            'total_vote' => $this->faker->word(),
            'total_recu' => $this->faker->word(),
            'budget_id' => Budget::factory(),
        ];
    }
}
