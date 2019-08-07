<?php

use Illuminate\Database\Seeder;

class EventTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('event_types')->delete();
        
        \DB::table('event_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'type' => 'Public',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'type' => 'Reservation',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'type' => 'HOA_Administrative',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}