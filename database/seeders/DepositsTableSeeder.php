<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DepositsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Deposit::factory(10)->create();        
    }
}
