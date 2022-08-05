<?php

use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('events')->delete();
        
        \DB::table('events')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'test',
                'size' => 15,
                'date' => '2019-10-31',
                'start_time' => '09:00:00',
                'end_time' => '10:00:00',
                'user_id' => 3,
                'reservable_id' => 1,
                'event_type_id' => 1,
                'reservation_fee' => 0,
                'security_deposit' => 200,
                'agree_to_terms' => 1,
                'esign_consent' => 1,
                'stripe_charge_id' => 'na',
                'stripe_receipt_url' => 'na',
                'reserved_from_ip_address' => '1.1.1.1',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}