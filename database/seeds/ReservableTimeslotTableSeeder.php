<?php

use Illuminate\Database\Seeder;

class ReservableTimeslotTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reservable_timeslot')->delete();

        $reservable_timeslot = [
            ['reservable_id'=>'2', 'timeslot_id'=>'1'],
            ['reservable_id'=>'2', 'timeslot_id'=>'2'],
            ['reservable_id'=>'2', 'timeslot_id'=>'3'],
            ['reservable_id'=>'2', 'timeslot_id'=>'4'],
            ['reservable_id'=>'2', 'timeslot_id'=>'5'],
            ['reservable_id'=>'2', 'timeslot_id'=>'6'],
            ['reservable_id'=>'2', 'timeslot_id'=>'7'],
            ['reservable_id'=>'2', 'timeslot_id'=>'8'],
            ['reservable_id'=>'2', 'timeslot_id'=>'9'],
            ['reservable_id'=>'2', 'timeslot_id'=>'10'],
            ['reservable_id'=>'2', 'timeslot_id'=>'11'],
            ['reservable_id'=>'2', 'timeslot_id'=>'12'],
            ['reservable_id'=>'2', 'timeslot_id'=>'13'],
            ['reservable_id'=>'2', 'timeslot_id'=>'14'],
            ['reservable_id'=>'2', 'timeslot_id'=>'15'],
            ['reservable_id'=>'2', 'timeslot_id'=>'16'],
            ['reservable_id'=>'1', 'timeslot_id'=>'17'],
            ['reservable_id'=>'1', 'timeslot_id'=>'18'],
            ['reservable_id'=>'1', 'timeslot_id'=>'19'],
            ['reservable_id'=>'1', 'timeslot_id'=>'20'],
            ['reservable_id'=>'3', 'timeslot_id'=>'17'],
            ['reservable_id'=>'3', 'timeslot_id'=>'18'],
            ['reservable_id'=>'3', 'timeslot_id'=>'19'],
            ['reservable_id'=>'3', 'timeslot_id'=>'20'],
        ];

        DB::table('reservable_timeslot')->insert($reservable_timeslot);
    }
}
