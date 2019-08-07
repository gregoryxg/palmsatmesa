<?php

use Illuminate\Database\Seeder;

class TimeslotsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('timeslots')->delete();
        
        \DB::table('timeslots')->insert(array (
            0 => 
            array (
                'id' => 1,
                'start_time' => '11:00:00',
                'end_time' => '15:00:00',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'start_time' => '17:00:00',
                'end_time' => '21:00:00',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'start_time' => '11:00:00',
                'end_time' => '12:00:00',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'start_time' => '12:00:00',
                'end_time' => '13:00:00',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'start_time' => '13:00:00',
                'end_time' => '14:00:00',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'start_time' => '14:00:00',
                'end_time' => '15:00:00',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'start_time' => '17:00:00',
                'end_time' => '18:00:00',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'start_time' => '18:00:00',
                'end_time' => '19:00:00',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'start_time' => '19:00:00',
                'end_time' => '20:00:00',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'start_time' => '20:00:00',
                'end_time' => '21:00:00',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}