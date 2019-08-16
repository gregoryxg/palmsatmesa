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
        ));
        
        
    }
}