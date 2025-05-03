<?php

namespace Database\Factories;

use App\Models\Workship;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\Rolenum;

class WorkshipFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Workship::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'amount' => $this->faker->randomElement(array(10, 10000, 15000, 1500, 100, 20000, 5000, 3000, 2000)),
            'comment' => $this->faker->text(500),
            'user_id' => $this->faker->randomElement(\App\Models\User::role(Rolenum::CHRISTIAN->value)->pluck('id')->toArray()),
            'dated_at' => $this->faker->dateTimeBetween('-4 weeks', '+4 weeks'),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }
}
