<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\map;

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

        $column = array('type', 'name', 'email', 'password');
        $seeder = array(
            array('Employee', 'Tommy Saputra Wijaya', 'tommy.wijaya54@yahoo.com', '$2y$10$5jVX3q8h6GnAqwN9KR9sVekmwYZQh0daV5.i65bzdXJMRYi/mtMZi'),
            array('Employee', 'Eko Saputra Wijaya', 'eko.saputra.wijaya@gmail.com', '$2y$10$5jVX3q8h6GnAqwN9KR9sVekmwYZQh0daV5.i65bzdXJMRYi/mtMZi'),
            array('Employee', 'Shinta Purnama Sari', 'shinta.purnama.sari@outlook.com', '$2y$10$5jVX3q8h6GnAqwN9KR9sVekmwYZQh0daV5.i65bzdXJMRYi/mtMZi'),
            array('Employee', 'Dewi Puspita Sari', 'dewi.puspita.sari@email.com', '$2y$10$5jVX3q8h6GnAqwN9KR9sVekmwYZQh0daV5.i65bzdXJMRYi/mtMZi'),
            array('Employee', 'Tony', 'tony@email.com', '$2y$10$5jVX3q8h6GnAqwN9KR9sVekmwYZQh0daV5.i65bzdXJMRYi/mtMZi')
        );
        runSeederInBatch($seeder, $column, "users");

        User::findByName('Tony')->assignRole('Owner');

        User::findByName('Eko Saputra Wijaya')->assignRole('Branch Manager');
        User::findByName('Shinta Purnama Sari')->assignRole('Advisor');

        // Tommy
        $tommy = User::findByName('Tommy Saputra Wijaya');
        $tommy->assignRole('super-admin');
        $tommy->assignRole('Owner');
        Employee::create([
            'nik' => '077-123-100',
            'name' => $tommy->name,
            'address' => 'U2 / 33 Carpenter street, Lakes Entrance, Victoria, 3909',
            'phone' => '0491 691 242',
            'email' => $tommy->email,
            'emergency_name' => 'Sisca Lancaster',
            'emergency_phone' => '0458 897 789',
            'join_date' => '2022-06-04',
            'users_id' => $tommy->id,
            'branches_id' => '3',
            'note' => 'No explanation present',
        ]);


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
