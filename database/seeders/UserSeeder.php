<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        function runSeederInBatch($seeder, $column, $tablename)
        {
            foreach ($seeder as $seed) {
                $insert = [];
                foreach ($column as $index => $col) {
                    if (isset($seed[$index])) {
                        $insert[$col] = $seed[$index];
                    }
                }
                DB::table($tablename)->insert($insert);
            }
        };

        $seeder = array(
            array('Employee', 'Tommy Saputra Wijaya', 'tommy.wijaya54@yahoo.com', '$2y$10$5jVX3q8h6GnAqwN9KR9sVekmwYZQh0daV5.i65bzdXJMRYi/mtMZi'),
            array('Employee', 'Eko Saputra Wijaya', 'eko.saputra.wijaya@gmail.com', '$2y$10$5jVX3q8h6GnAqwN9KR9sVekmwYZQh0daV5.i65bzdXJMRYi/mtMZi'),
            array('Employee', 'Shinta Purnama Sari', 'shinta.purnama.sari@outlook.com', '$2y$10$5jVX3q8h6GnAqwN9KR9sVekmwYZQh0daV5.i65bzdXJMRYi/mtMZi'),
            array('Employee', 'Dewi Puspita Sari', 'dewi.puspita.sari@email.com', '$2y$10$5jVX3q8h6GnAqwN9KR9sVekmwYZQh0daV5.i65bzdXJMRYi/mtMZi'),
            array('Employee', 'Tony', 'tony@email.com', '$2y$10$5jVX3q8h6GnAqwN9KR9sVekmwYZQh0daV5.i65bzdXJMRYi/mtMZi')
        );
        $column = array('type', 'name', 'email', 'password');
        runSeederInBatch($seeder, $column, "users");

        User::findByName('Tony')->assignRole('Owner');
        User::findByName('Tommy Saputra Wijaya')->assignRole('super-admin');
        User::findByName('Tommy Saputra Wijaya')->assignRole('Owner');
        User::findByName('Eko Saputra Wijaya')->assignRole('Branch Manager');
        User::findByName('Shinta Purnama Sari')->assignRole('Advisor');


        for ($x = 1; $x <= 10; $x++) {
            $arr = [
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'password' => fake()->text(20),
                'type' => 'Student',
            ];
            DB::table('users')->insert($arr);
        }

        for ($x = 1; $x <= 10; $x++) {
            $arr = [
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'password' => fake()->text(20),
                'type' => 'Parent',
            ];
            DB::table('users')->insert($arr);
        }

        /*
        for ($x = 1; $x <= 20; $x++) {
            $arr = [
                'role_id' => fake()->numberBetween($min = 1, $max = 7),
                'model_type' => 'App\\Models\\User',
                'model_id' => fake()->numberBetween($min = 5, $max = 20),
            ];
            DB::table('model_has_roles')->insert($arr);
        }
        */
    }
}
