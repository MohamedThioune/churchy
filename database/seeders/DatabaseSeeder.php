<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /** Seed roles first  */
        $this->call([
            RolePermissionSeeder::class,
        ]);

        \App\Models\User::factory(10)->create();

        /** Continue with seeders */
        $this->call([
            ExpensesTableSeeder::class,
            DepositsTableSeeder::class,
            DemandsTableSeeder::class,
            WorkshipsTableSeeder::class,
            TithesTableSeeder::class,
            PaymentsTableSeeder::class,
            SacramentsTableSeeder::class,
            DonLegsTableSeeder::class,
        ]);


    }
}
