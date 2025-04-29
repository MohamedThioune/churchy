<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ExpensesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Expense::factory(10)->create();        
    }
}
