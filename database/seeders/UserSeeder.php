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

        $column = array('type', 'status', 'name', 'email', 'password');
        $seeder = array(
            array('Employee', '', 'Tommy Saputra Wijaya', 'tommy.wijaya54@yahoo.com', '$2y$10$5jVX3q8h6GnAqwN9KR9sVekmwYZQh0daV5.i65bzdXJMRYi/mtMZi'),
            array('Login User Only', 'Not Registered as employee', 'Eko Saputra Wijaya', 'eko.saputra.wijaya@gmail.com', '$2y$10$5jVX3q8h6GnAqwN9KR9sVekmwYZQh0daV5.i65bzdXJMRYi/mtMZi'),
            array('Login User Only', 'Not Registered as employee', 'Shinta Purnama Sari', 'shinta.purnama.sari@outlook.com', '$2y$10$5jVX3q8h6GnAqwN9KR9sVekmwYZQh0daV5.i65bzdXJMRYi/mtMZi'),
            array('Login User Only', 'Not Registered as employee', 'Dewi Puspita Sari', 'dewi.puspita.sari@email.com', '$2y$10$5jVX3q8h6GnAqwN9KR9sVekmwYZQh0daV5.i65bzdXJMRYi/mtMZi'),
            array('Login User Only', 'Not Registered as employee', 'Tonny ho', 'tonnyho.id@gmail.com', '$2y$10$5jVX3q8h6GnAqwN9KR9sVekmwYZQh0daV5.i65bzdXJMRYi/mtMZi')
        );

        runSeederInBatch($seeder, $column, "users");

        User::findByName('Tonny ho')->assignRole('Owner');
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
            'user_id' => $tommy->id,
            'branch_id' => '3',
            'note' => 'No explanation present',
        ]);
    }
}
