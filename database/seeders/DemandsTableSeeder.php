<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DemandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Demand::factory(10)->create();        
    }
}
