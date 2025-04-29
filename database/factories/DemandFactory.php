<?php

namespace Database\Factories;

use App\Models\Demand;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\Rolenum;

class DemandFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Demand::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'intention' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'user_id' => $this->faker->randomElement(\App\Models\User::role(Rolenum::CHRISTIAN->value)->pluck('id')->toArray()),
            'comment' => $this->faker->text(500),
            'messed_at' => $this->faker->dateTimeBetween('-4 weeks', '+4 weeks'),
            'created_at' => $this->faker->dateTimeBetween('-4 weeks', '+4 weeks'),
        ];
    }
}
