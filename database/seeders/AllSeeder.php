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
        /*

        for ($x = 1; $x <= 10; $x++) {
            $arr = ['name' => fake('id_ID')->name(), 'email' => fake('id_ID')->unique()->safeEmail(), 'password' => fake('id_ID')->text(20),];
            DB::table('users')->insert($arr);
        }
        */

        /*
        for ($x = 1; $x <= 30; $x++) {
            $arr = [
                'nik' => fake('id_ID')->randomDigit(),
                'name' => fake('id_ID')->name(),
                'address' => fake('id_ID')->address(),
                'phone' => fake('id_ID')->phoneNumber(),
                'email' => fake('id_ID')->unique()->safeEmail(),
                'emergency_name' => fake('id_ID')->name(),
                'emergency_phone' => fake('id_ID')->phoneNumber(),
                'join_date' => fake('id_ID')->date(),
                'exit_date' => fake('id_ID')->date(),
                'note' => fake('id_ID')->text(50),
                'user_id' => fake('id_ID')->numberBetween($min = 1, $max = 10),
                'branche_id' => fake('id_ID')->numberBetween($min = 1, $max = 4),
            ];
            DB::table('employees')->insert($arr);
        }
        */

        for ($x = 1; $x <= 4; $x++) {
            $arr = ['employee_id' => fake('id_ID')->numberBetween($min = 1, $max = 10), 'branche_id' => fake('id_ID')->numberBetween($min = 1, $max = 4), 'note' => fake('id_ID')->text(50),];
            DB::table('managers')->insert($arr);
        }

        /*
        for ($x = 1; $x <= 4; $x++) {
            $arr = ['name' => fake('id_ID')->name(), 'address' => fake('id_ID')->address(), 'phone' => fake('id_ID')->phoneNumber(), 'manager_id' => fake('id_ID')->numberBetween($min = 1, $max = 10), 'email' => fake('id_ID')->unique()->safeEmail(), 'open_date' => fake('id_ID')->date(), 'status' => fake('id_ID')->text(10),];
            DB::table('branches')->insert($arr);
        }
        */

        for ($x = 1; $x <= 10; $x++) {
            $arr = ['branche_id' => fake('id_ID')->numberBetween($min = 1, $max = 4), 'expense_type' => fake('id_ID')->text(), 'description' => fake('id_ID')->text(), 'amount' => fake('id_ID')->numberBetween($min = 1500, $max = 6000), 'date' => fake('id_ID')->date(), 'approve_by' => fake('id_ID')->text(),];
            DB::table('expenses')->insert($arr);
        }

        for ($x = 1; $x <= 10; $x++) {
            $arr = ['branche_id' => fake('id_ID')->numberBetween($min = 1, $max = 4), 'start_date' => fake('id_ID')->date(), 'end_date' => fake('id_ID')->date(), 'amount' => fake('id_ID')->numberBetween($min = 1500, $max = 6000), 'owner_name' => fake('id_ID')->name(), 'owner_phone' => fake('id_ID')->phoneNumber(), 'notaris_name' => fake('id_ID')->name(), 'notaris_phone' => fake('id_ID')->phoneNumber(),];
            DB::table('rentals')->insert($arr);
        }

        for ($x = 1; $x <= 10; $x++) {
            $arr = ['branche_id' => fake('id_ID')->numberBetween($min = 1, $max = 4), 'item_name' => fake('id_ID')->name(), 'qty' => fake('id_ID')->randomDigitNotNull(), 'cost' => fake('id_ID')->numberBetween($min = 1500, $max = 6000), 'note' => fake('id_ID')->text(50),];
            DB::table('assets')->insert($arr);
        }

        /*
        for ($x = 1; $x <= 10; $x++) {
            $arr = [
                'nik' => fake('id_ID')->text(),
                'name' => fake('id_ID')->name(),
                'address' => fake('id_ID')->address(),
                'phone' => fake('id_ID')->phoneNumber(),
                'email' => fake('id_ID')->unique()->safeEmail(),
                'birth_date' => fake('id_ID')->date(),
                'emergency_name' => fake('id_ID')->name(),
                'emergency_phone' => fake('id_ID')->phoneNumber(),
                'bank_account_name' => fake('id_ID')->text(),
                'virtual_account_name' => fake('id_ID')->text(),
                'note' => fake('id_ID')->text(50),
                'user_id' => fake('id_ID')->numberBetween($min = 15, $max = 30),
                'blacklist' => fake('id_ID')->randomElement(['true', 'false']),
            ];
            DB::table('cparents')->insert($arr);
        }
        */

        /*
        for ($x = 1; $x <= 30; $x++) {
            $arr = [
                'cparent_id' => fake('id_ID')->numberBetween($min = 1, $max = 10),
                'school_id' => fake('id_ID')->numberBetween($min = 1, $max = 10),
                'grade' => fake('id_ID')->text(),
                'name' => fake('id_ID')->name(),
                'email' => fake('id_ID')->unique()->safeEmail(),
                'phone' => fake('id_ID')->phoneNumber(),
                'address' => fake('id_ID')->address(),
                'join_date' => fake('id_ID')->date(),
                'exit_date' => fake('id_ID')->date(),
                'exit_reason' => fake('id_ID')->text(),
                'birth_date' => fake('id_ID')->date(),
                'type' => fake('id_ID')->sentence(4),
                'health_condition' => fake('id_ID')->sentence(4),
                'user_id' => fake('id_ID')->numberBetween($min = 1, $max = 10),
                'note' => fake('id_ID')->text(50),
            ];
            DB::table('students')->insert($arr);
        }
        */

        for ($x = 1; $x <= 10; $x++) {
            $arr = ['name' => fake('id_ID')->name(), 'address' => fake('id_ID')->address(), 'city' => fake('id_ID')->randomElement(['Jakarta Barat', 'Jakarta Timur', 'Jakarta Selatan']), 'type' => fake('id_ID')->sentence(4), 'color_code' => fake('id_ID')->randomElement(['blue', 'yellow', 'red']),];
            DB::table('schools')->insert($arr);
        }

        for ($x = 1; $x <= 10; $x++) {
            $arr = ['start_date' => fake('id_ID')->date(), 'end_date' => fake('id_ID')->date(), 'level' => fake('id_ID')->randomElement(['Discount 30%', 'Grand Opening Discount']), 'school_type' => fake('id_ID')->randomElement(['International', 'National', 'International-National']), 'subject' => fake('id_ID')->sentence(3), 'price' => fake('id_ID')->numberBetween($min = 1500, $max = 6000), 'week' => fake('id_ID')->text(), 'branche_id' => fake('id_ID')->numberBetween($min = 1, $max = 4),];
            DB::table('pricelists')->insert($arr);
        }

        for ($x = 1; $x <= 10; $x++) {
            $arr = ['start_date' => fake('id_ID')->date(), 'end_date' => fake('id_ID')->date(), 'label' => fake('id_ID')->text(), 'discount_value' => fake('id_ID')->randomElement(['30%', '-200000']), 'branche_id' => fake('id_ID')->numberBetween($min = 1, $max = 4),];
            DB::table('promolists')->insert($arr);
        }

        for ($x = 1; $x <= 50; $x++) {
            $arr = ['student_id' => fake('id_ID')->numberBetween($min = 1, $max = 10), 'branche_id' => fake('id_ID')->numberBetween($min = 1, $max = 4), 'date' => fake('id_ID')->date(), 'reference' => fake('id_ID')->text(50), 'cashback' => fake('id_ID')->randomElement([100000, 280000, 300000]), 'status' => fake('id_ID')->text(10), 'note' => fake('id_ID')->text(50),];
            DB::table('registrations')->insert($arr);
        }

        for ($x = 1; $x <= 10; $x++) {
            $arr = ['registration_id' => fake('id_ID')->numberBetween($min = 1, $max = 10), 'pricelist_id' => fake('id_ID')->numberBetween($min = 1, $max = 10), 'promolist_id' => fake('id_ID')->numberBetween($min = 1, $max = 10), 'charges' => fake('id_ID')->text(), 'price' => fake('id_ID')->numberBetween($min = 1500, $max = 6000), 'discount_amount' => fake('id_ID')->text(),];
            DB::table('registrationitems')->insert($arr);
        }

        for ($x = 1; $x <= 10; $x++) {
            $arr = ['employee_id' => fake('id_ID')->numberBetween($min = 1, $max = 10), 'amount' => fake('id_ID')->numberBetween($min = 1500, $max = 6000), 'start_date' => fake('id_ID')->date(), 'end_date' => fake('id_ID')->date(), 'note' => fake('id_ID')->text(50),];
            DB::table('salaries')->insert($arr);
        }

        for ($x = 1; $x <= 10; $x++) {
            $arr = ['employee_id' => fake('id_ID')->numberBetween($min = 1, $max = 10), 'note' => fake('id_ID')->text(50),];
            DB::table('advisors')->insert($arr);
        }

        for ($x = 1; $x <= 10; $x++) {
            $arr = ['employee_id' => fake('id_ID')->numberBetween($min = 1, $max = 10), 'subject' => fake('id_ID')->sentence(3), 'note' => fake('id_ID')->text(50),];
            DB::table('teachers')->insert($arr);
        }

        for ($x = 1; $x <= 10; $x++) {
            $arr = ['teacher_id' => fake('id_ID')->numberBetween($min = 1, $max = 10), 'subject' => fake('id_ID')->sentence(3), 'school' => fake('id_ID')->text(),];
            DB::table('subjects')->insert($arr);
        }

        for ($x = 1; $x <= 10; $x++) {
            $arr = ['employee_id' => fake('id_ID')->numberBetween($min = 1, $max = 10), 'role_title' => fake('id_ID')->text(), 'start_date' => fake('id_ID')->date(), 'end_date' => fake('id_ID')->date(),];
            DB::table('employeeroles')->insert($arr);
        }

        for ($x = 1; $x <= 10; $x++) {
            $arr = ['action' => fake('id_ID')->text(),];
            DB::table('actionhistories')->insert($arr);
        }

        for ($x = 1; $x <= 20; $x++) {
            $arr = ['day' => fake('id_ID')->date(), 'time_slot' => fake('id_ID')->time(), 'subject' => fake('id_ID')->sentence(3), 'classroom' => fake('id_ID')->sentence(1), 'duration' => fake('id_ID')->randomElement(["1", "1.5", "2"]), 'date' => fake('id_ID')->date(),];
            DB::table('schedules')->insert($arr);
        }
    }
}
