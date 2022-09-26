<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $school_name =
            ['Tzu Chi', 'Permai Plus', 'Penabur', 'SIS', 'IPEKA', 'SPH', 'Cikal', 'Bent Tree', 'Ghandi', 'BMS'];

        for (
            $x = 0;
            $x < count($school_name);
            $x++
        ) {
            $arr = [
                'name' => $school_name[$x],
                'address' => fake('id_ID')->address(),
                'city' => fake('id_ID')->randomElement(['Jakarta Barat', 'Jakarta Timur', 'Jakarta Selatan', 'Jakarta Utara']),
                'type' => fake('id_ID')->randomElement(['International', 'National', 'International - National']),
                'color_code' => fake('id_ID')->randomElement(['blue', 'yellow', 'red']),
            ];
            DB::table('schools')->insert($arr);
        }
    }
}
