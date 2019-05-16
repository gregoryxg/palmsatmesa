<?php

use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->delete();

        $events = [
            ['title'=>'Test Event 1',
                'reservable_id'=> 1,
                'size'=> 10,
                'date'=> '2019-05-30',
                'timeslot_id'=>17,
                'user_id'=>1,
                'agree_to_terms'=>true,
                'esign_consent'=>true,
                'reserved_from_ip_address'=>'test ip address']
        ];

        DB::table('events')->insert($events);
    }
}
