<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Pricelist;
use App\Models\Promolist;
use App\Models\Registration;
use App\Models\RegistrationItem;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $students = Student::pluck('id');
        $branches = Branch::pluck('id');

        for ($x = 1; $x <= 20; $x++) {
            $arr = [
                'student_id' => $students->random(),
                'branch_id' => $branches->random(),
                'date' => fake('id_ID')->date(),
                'reference' => fake('id_ID')->text(50),
                'cashback' => fake('id_ID')->randomElement([100000, 280000, 300000]),
                'status' => fake('id_ID')->text(10),
                'note' => fake('id_ID')->text(50)
            ];
            DB::table('registrations')->insert($arr);
        }

        $registrations = Registration::pluck('id');
        $promolist = Promolist::pluck('id');
        $pricelist = Pricelist::pluck('id');

        $registrations->each(function ($reg) use ($promolist, $pricelist) {
            for ($x = 1; $x <= 10; $x++) {
                $arr = [
                    'registration_id' => $reg,
                    'pricelist_id' => $promolist->random(),
                    'promolist_id' => $pricelist->random(),
                    'charges' => fake('id_ID')->text(80),
                    'price' => fake('id_ID')->numberBetween($min = 1500, $max = 6000),
                    'discount_amount' => fake('id_ID')->text()
                ];
                RegistrationItem::create($arr);
            }
        });
    }
}
