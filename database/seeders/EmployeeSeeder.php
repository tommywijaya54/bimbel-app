<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $Branches = Branch::all();

        for ($x = 1; $x <= 5; $x++) {
            $people = [
                'nik' => fake()->randomDigit() . '99-999-Employee',
                'name' => fake()->name(),
                'address' => fake()->address(),
                'phone' => fake()->phoneNumber(),
                'email' => fake()->unique()->safeEmail(),
                'emergency_name' => fake()->name(),
                'emergency_phone' => fake()->phoneNumber(),
                'join_date' => fake()->date(),
                'exit_date' => fake()->date(),
                'note' => fake()->text(50),
            ];

            $user = [
                'name' => $people['name'],
                'email' => $people['email'],
                'type' => 'Employee',
                'password' => 'xxx - employee'
            ];

            $User = User::create($user);

            $people['user_id'] = $User->id;
            $people['branche_id'] = $Branches->random()->id;

            DB::table('employees')->insert($people);
        }
    }
}
