<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleAndPermissionSeeder::class,
            UserSeeder::class,

            BranchSeeder::class,
            BranchExpensesSeeder::class,
            SchoolSeeder::class,

            EmployeeSeeder::class,
            ParentSeeder::class,
            StudentSeeder::class,

            OtherSeeder::class,
            AllSeeder::class,

            RegistrationSeeder::class,
        ]);
    }
}
