<?php

use Illuminate\Database\Seeder;

class ReservableTimeslotTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('reservable_timeslot')->delete();
        
        \DB::table('reservable_timeslot')->insert(array (
            0 => 
            array (
                'id' => 1,
                'reservable_id' => 1,
                'timeslot_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'reservable_id' => 1,
                'timeslot_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'reservable_id' => 2,
                'timeslot_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'reservable_id' => 2,
                'timeslot_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'reservable_id' => 3,
                'timeslot_id' => 3,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'reservable_id' => 3,
                'timeslot_id' => 4,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'reservable_id' => 3,
                'timeslot_id' => 5,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'reservable_id' => 3,
                'timeslot_id' => 6,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'reservable_id' => 3,
                'timeslot_id' => 7,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'reservable_id' => 3,
                'timeslot_id' => 8,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'reservable_id' => 3,
                'timeslot_id' => 9,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'reservable_id' => 3,
                'timeslot_id' => 10,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}