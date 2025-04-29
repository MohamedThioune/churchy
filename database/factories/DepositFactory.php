<?php

namespace Database\Factories;

use App\Models\Deposit;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\Rolenum;

class DepositFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Deposit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'amount' => $this->faker->randomElement(array(10, 10000, 15000, 1500, 100, 20000, 5000, 3000, 2000)),
            'destination' => $this->faker->randomElement(array('Église','École','Caisse')),
            'user_id' => $this->faker->randomElement(\App\Models\User::role(Rolenum::CASHIER->value)->pluck('id')->toArray()),
            'comment' => $this->faker->text(500),
            'created_at' => $this->faker->dateTimeBetween('-4 weeks', '+4 weeks'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
