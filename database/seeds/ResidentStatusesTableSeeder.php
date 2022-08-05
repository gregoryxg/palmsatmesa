<?php

use Illuminate\Database\Seeder;

class ResidentStatusesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('resident_statuses')->delete();
        
        \DB::table('resident_statuses')->insert(array (
            0 => 
            array (
                'id' => 1,
                'status' => 'Homeowner',
                'add_to_calendar' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'status' => 'Renter',
                'add_to_calendar' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}