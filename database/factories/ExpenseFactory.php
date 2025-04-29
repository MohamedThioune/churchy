<?php

namespace Database\Factories;

use App\Models\Expense;
use Illuminate\Database\Eloquent\Factories\Factory;


class ExpenseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Expense::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'reason' => $this->faker->word(),
            'type' => $this->faker->randomElement(array('Salaires et honoraires','Aide aux paroissiens','Événements paroissiaux','Frais administratifs','Autres')),
            'amount' => $this->faker->randomElement(array(10, 10000, 15000, 1500, 100, 20000, 5000, 3000, 2000)),
            'authorizer' => $this->faker->randomElement(array('Curé','Trésorier','Vicaire','Autres')),
            'comment' => $this->faker->words(10, true),
            'created_at' => $this->faker->dateTimeBetween('-4 weeks', '+4 weeks'),
        ];
    }
}
