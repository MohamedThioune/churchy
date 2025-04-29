<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SacramentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Sacrament::factory(10)->create();
    }
}
