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
            'type' => $this->faker->randomElement(array('Repose de l\'ame', 'Messe', 'Prier pour un proche', 'Prier pour moi')),
            'amount' => $this->faker->randomElement(array(10, 10000, 15000, 1500, 100, 20000, 5000, 3000, 2000)),
            'intention' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'user_id' => $this->faker->randomElement(\App\Models\User::role(Rolenum::CHRISTIAN->value)->pluck('id')->toArray()),
            'comment' => $this->faker->text(500),
            'dated_at' => $this->faker->dateTimeBetween('-4 weeks', '+4 weeks'),
            'created_at' => $this->faker->dateTimeBetween('-4 weeks', '+4 weeks'),
        ];
    }
}
