<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\map;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {
        $Users = User::all();
        //
        $branch_names = [
            'Bimbel - Jakarta Timur',
            'Bimbel - Jakarta Barat',
            'Bimbel - Jakarta Utara',
            'Bimbel - Jakarta Selatan'
        ];

        for (
            $x = 0;
            $x < count($branch_names);
            $x++
        ) {
            $branch = [
                'name' => $branch_names[$x],
                'address' => fake('id_ID')->address(),
                'phone' => fake('id_ID')->phoneNumber(),
                'manager_id' => $Users->random()->id,
                'email' => fake('id_ID')->unique()->safeEmail(),
                'open_date' => fake('id_ID')->date(),
                'status' => fake('id_ID')->text(10),
            ];

            DB::table('branches')->insert($branch);
        }
    }
}
