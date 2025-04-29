<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class WorkshipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Workship::factory(10)->create();        

    }
}
