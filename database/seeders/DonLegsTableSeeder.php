<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DonLegsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\DonLeg::factory(10)->create();
    }
}
