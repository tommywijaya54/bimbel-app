<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class AllSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($x = 1; $x <= 10; $x++) {
            $arr = ['name' => fake()->name(), 'email' => fake()->unique()->safeEmail(), 'password' => fake()->text(20),];
            DB::table('users')->insert($arr);
        }

        for ($x = 1; $x <= 30; $x++) {
            $arr = [
                'nik' => fake()->randomDigit(),
                'name' => fake()->name(),
                'address' => fake()->address(),
                'phone' => fake()->phoneNumber(),
                'email' => fake()->unique()->safeEmail(),
                'emergency_name' => fake()->name(),
                'emergency_phone' => fake()->phoneNumber(),
                'join_date' => fake()->date(),
                'exit_date' => fake()->date(),
                'note' => fake()->text(50),
                'users_id' => fake()->numberBetween($min = 1, $max = 10),
                'branches_id' => fake()->numberBetween($min = 1, $max = 4),
            ];
            DB::table('employees')->insert($arr);
        }

        for ($x = 1; $x <= 4; $x++) {
            $arr = ['employees_id' => fake()->numberBetween($min = 1, $max = 10), 'branches_id' => fake()->numberBetween($min = 1, $max = 4), 'note' => fake()->text(50),];
            DB::table('managers')->insert($arr);
        }

        for ($x = 1; $x <= 4; $x++) {
            $arr = ['name' => fake()->name(), 'address' => fake()->address(), 'phone' => fake()->phoneNumber(), 'managers_id' => fake()->numberBetween($min = 1, $max = 10), 'email' => fake()->unique()->safeEmail(), 'open_date' => fake()->date(), 'status' => fake()->text(10),];
            DB::table('branches')->insert($arr);
        }

        for ($x = 1; $x <= 10; $x++) {
            $arr = ['branches_id' => fake()->numberBetween($min = 1, $max = 4), 'expense_type' => fake()->text(), 'description' => fake()->text(), 'amount' => fake()->numberBetween($min = 1500, $max = 6000), 'date' => fake()->date(), 'approve_by' => fake()->text(),];
            DB::table('expenses')->insert($arr);
        }

        for ($x = 1; $x <= 10; $x++) {
            $arr = ['branches_id' => fake()->numberBetween($min = 1, $max = 4), 'start_date' => fake()->date(), 'end_date' => fake()->date(), 'amount' => fake()->numberBetween($min = 1500, $max = 6000), 'owner_name' => fake()->name(), 'owner_phone' => fake()->phoneNumber(), 'notaris_name' => fake()->name(), 'notaris_phone' => fake()->phoneNumber(),];
            DB::table('rentals')->insert($arr);
        }

        for ($x = 1; $x <= 10; $x++) {
            $arr = ['branches_id' => fake()->numberBetween($min = 1, $max = 4), 'item_name' => fake()->name(), 'qty' => fake()->randomDigitNotNull(), 'cost' => fake()->numberBetween($min = 1500, $max = 6000), 'note' => fake()->text(50),];
            DB::table('assets')->insert($arr);
        }

        for ($x = 1; $x <= 10; $x++) {
            $arr = ['nik' => fake()->text(), 'name' => fake()->name(), 'address' => fake()->address(), 'phone' => fake()->phoneNumber(), 'email' => fake()->unique()->safeEmail(), 'birth_date' => fake()->date(), 'emergency_name' => fake()->name(), 'emergency_phone' => fake()->phoneNumber(), 'bank_account_name' => fake()->text(), 'virtual_account_name' => fake()->text(), 'note' => fake()->text(50), 'user_id' => fake()->numberBetween($min = 1, $max = 10), 'blacklist' => fake()->randomElement(['true', 'false']),];
            DB::table('cparents')->insert($arr);
        }

        for ($x = 1; $x <= 30; $x++) {
            $arr = ['cparents_id' => fake()->numberBetween($min = 1, $max = 10), 'schools_id' => fake()->numberBetween($min = 1, $max = 10), 'grade' => fake()->text(), 'name' => fake()->name(), 'email' => fake()->unique()->safeEmail(), 'phone' => fake()->phoneNumber(), 'address' => fake()->address(), 'join_date' => fake()->date(), 'exit_date' => fake()->date(), 'exit_reason' => fake()->text(), 'birth_date' => fake()->date(), 'type' => fake()->sentence(4), 'health_condition' => fake()->sentence(4), 'note' => fake()->text(50),];
            DB::table('students')->insert($arr);
        }

        for ($x = 1; $x <= 10; $x++) {
            $arr = ['name' => fake()->name(), 'address' => fake()->address(), 'city' => fake()->randomElement(['Jakarta Barat', 'Jakarta Timur', 'Jakarta Selatan']), 'type' => fake()->sentence(4), 'color_code' => fake()->randomElement(['blue', 'yellow', 'red']),];
            DB::table('schools')->insert($arr);
        }

        for ($x = 1; $x <= 10; $x++) {
            $arr = ['start_date' => fake()->date(), 'end_date' => fake()->date(), 'level' => fake()->randomElement(['Discount 30%', 'Grand Opening Discount']), 'school_type' => fake()->randomElement(['International', 'National', 'International-National']), 'subject' => fake()->sentence(3), 'price' => fake()->numberBetween($min = 1500, $max = 6000), 'week' => fake()->text(), 'branches_id' => fake()->numberBetween($min = 1, $max = 4),];
            DB::table('pricelists')->insert($arr);
        }

        for ($x = 1; $x <= 10; $x++) {
            $arr = ['start_date' => fake()->date(), 'end_date' => fake()->date(), 'label' => fake()->text(), 'discount_value' => fake()->randomElement(['30%', '-200000']), 'branches_id' => fake()->numberBetween($min = 1, $max = 4),];
            DB::table('promolists')->insert($arr);
        }

        for ($x = 1; $x <= 50; $x++) {
            $arr = ['students_id' => fake()->numberBetween($min = 1, $max = 10), 'branches_id' => fake()->numberBetween($min = 1, $max = 4), 'date' => fake()->date(), 'reference' => fake()->text(50), 'cashback' => fake()->randomElement([100000, 280000, 300000]), 'status' => fake()->text(10), 'note' => fake()->text(50),];
            DB::table('registrations')->insert($arr);
        }

        for ($x = 1; $x <= 10; $x++) {
            $arr = ['registrations_id' => fake()->numberBetween($min = 1, $max = 10), 'pricelists_id' => fake()->numberBetween($min = 1, $max = 10), 'promolists_id' => fake()->numberBetween($min = 1, $max = 10), 'charges' => fake()->text(), 'price' => fake()->numberBetween($min = 1500, $max = 6000), 'discount_amount' => fake()->text(),];
            DB::table('registrationitems')->insert($arr);
        }

        for ($x = 1; $x <= 10; $x++) {
            $arr = ['employees_id' => fake()->numberBetween($min = 1, $max = 10), 'amount' => fake()->numberBetween($min = 1500, $max = 6000), 'start_date' => fake()->date(), 'end_date' => fake()->date(), 'note' => fake()->text(50),];
            DB::table('salaries')->insert($arr);
        }

        for ($x = 1; $x <= 10; $x++) {
            $arr = ['employees_id' => fake()->numberBetween($min = 1, $max = 10), 'note' => fake()->text(50),];
            DB::table('advisors')->insert($arr);
        }

        for ($x = 1; $x <= 10; $x++) {
            $arr = ['employees_id' => fake()->numberBetween($min = 1, $max = 10), 'subject' => fake()->sentence(3), 'note' => fake()->text(50),];
            DB::table('teachers')->insert($arr);
        }

        for ($x = 1; $x <= 10; $x++) {
            $arr = ['teachers_id' => fake()->numberBetween($min = 1, $max = 10), 'subject' => fake()->sentence(3), 'school' => fake()->text(),];
            DB::table('subjects')->insert($arr);
        }

        for ($x = 1; $x <= 10; $x++) {
            $arr = ['employees_id' => fake()->numberBetween($min = 1, $max = 10), 'role_title' => fake()->text(), 'start_date' => fake()->date(), 'end_date' => fake()->date(),];
            DB::table('employeeroles')->insert($arr);
        }

        for ($x = 1; $x <= 10; $x++) {
            $arr = ['action' => fake()->text(),];
            DB::table('actionhistories')->insert($arr);
        }

        for ($x = 1; $x <= 20; $x++) {
            $arr = ['day' => fake()->date(), 'time_slot' => fake()->time(), 'subject' => fake()->sentence(3), 'classroom' => fake()->sentence(1), 'duration' => fake()->randomElement(["1", "1.5", "2"]), 'date' => fake()->date(),];
            DB::table('schedules')->insert($arr);
        }
    }
}
