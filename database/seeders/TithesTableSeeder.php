<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TithesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Tithe::factory(10)->create();        

    }
}
