<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $teachers = User::role('Teacher')->pluck('id');
        $students = User::role('Student')->pluck('id');
        $branches = Branch::pluck('id');
        for (
            $x = 0;
            $x < 8;
            $x++
        ) {
            $week = fake('id_ID')->randomElement([6, 8, 12]);
            $studentlist = implode(',', fake('id_ID')->randomElements($students, random_int(3, 5)));

            // dd($studentlist);

            $schedule_data = [
                'class_subject' => fake('id_ID')->randomElement(['English', 'Math', 'Science']),
                'class_room' => fake('id_ID')->randomElement(['Room A', 'Room B', 'Room C']),
                'teacher_id' => $teachers->random(),
                'branch_id' => $branches->random(),
                'students' => $studentlist,
                'week' => $week
            ];

            $schedule = Schedule::create($schedule_data);

            for (
                $y = 0;
                $y < $week;
                $y++
            ) {

                $nextDate  = date('Y-m-d H:i:s', mktime(0, 0, 0, date("m"), date("d") + ($y * 7), date("Y")));
                $startTime = date('Y-m-d H:i:s', mktime(17, 0, 0, date("m"), date("d") + ($y * 7), date("Y")));
                $endTime = date('Y-m-d H:i:s', mktime(17, 0 + 30, 0, date("m"), date("d") + ($y * 7), date("Y")));

                $item = [
                    'session_date' => $nextDate,
                    'session_start_at' => $startTime,
                    'session_end_at' => $endTime
                ];

                $schedule->items()->create($item);
            }
        }
    }
}
