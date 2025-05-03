<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\Rolenum;

class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'type' => $this->faker->randomElement(array('Cotisation ponctuelle','Autres')),
            'target' => $this->faker->randomElement(array('Chrétien','Groupe')),
            'amount' => $this->faker->randomElement(array(10, 10000, 15000, 1500, 100, 20000, 5000, 3000, 2000)),
            'user_id' => $this->faker->randomElement(\App\Models\User::role(Rolenum::CHRISTIAN->value)->pluck('id')->toArray()),
            'dated_at' => $this->faker->dateTimeBetween('-4 weeks', '+4 weeks'),
            'created_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
