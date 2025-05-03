<?php

namespace Database\Factories;

use App\Models\Quest;
use Illuminate\Database\Eloquent\Factories\Factory;


class QuestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Quest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'amount' => $this->faker->randomElement(array(10, 10000, 15000, 1500, 100, 20000, 5000, 3000, 2000)),
            'type' => $this->faker->randomElement(array('Quête ordinaire', 'Quête impérée')),
            'location' => 'Paroisse ' . $this->faker->randomElement(array('Saint-Joseph', 'Koudougou')),
            'ceremony' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'quested_at' => $this->faker->dateTimeBetween('-4 weeks', '+4 weeks'),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }
}
