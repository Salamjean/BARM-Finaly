<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Budget;
use App\Models\Service;
use App\Models\User;

class BudgetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Budget::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->date(),
            'service_id' => Service::factory(),
            'status' => $this->faker->randomElement(["submitted","validated","refused","partial_validated"]),
            'user_id' => User::factory(),
        ];
    }
}
