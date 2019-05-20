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
            ['title'=>'Test Kitchen 1',
                'reservable_id'=> 1,
                'size'=> 10,
                'date'=> '2019-05-30',
                'timeslot_id'=>17,
                'event_type_id'=>2,
                'user_id'=>1,
                'agree_to_terms'=>true,
                'esign_consent'=>true,
                'reserved_from_ip_address'=>'test ip address'],
            ['title'=>'Test Kitchen 2',
                'reservable_id'=> 1,
                'size'=> 10,
                'date'=> '2019-05-30',
                'timeslot_id'=>18,
                'event_type_id'=>2,
                'user_id'=>1,
                'agree_to_terms'=>true,
                'esign_consent'=>true,
                'reserved_from_ip_address'=>'test ip address'],
            ['title'=>'Test Kitchen 3',
                'reservable_id'=> 1,
                'size'=> 10,
                'date'=> '2019-05-30',
                'timeslot_id'=>19,
                'event_type_id'=>2,
                'user_id'=>1,
                'agree_to_terms'=>true,
                'esign_consent'=>true,
                'reserved_from_ip_address'=>'test ip address'],
            ['title'=>'Test Kitchen 4',
                'reservable_id'=> 1,
                'size'=> 10,
                'date'=> '2019-05-30',
                'timeslot_id'=>20,
                'event_type_id'=>2,
                'user_id'=>1,
                'agree_to_terms'=>true,
                'esign_consent'=>true,
                'reserved_from_ip_address'=>'test ip address'],
            ['title'=>'Test Pool Room 1',
                'reservable_id'=> 2,
                'size'=> 10,
                'date'=> '2019-05-30',
                'timeslot_id'=>1,
                'event_type_id'=>2,
                'user_id'=>1,
                'agree_to_terms'=>true,
                'esign_consent'=>true,
                'reserved_from_ip_address'=>'test ip address'],
            ['title'=>'Test Pool Room 2',
                'reservable_id'=> 2,
                'size'=> 10,
                'date'=> '2019-05-30',
                'timeslot_id'=>2,
                'event_type_id'=>2,
                'user_id'=>1,
                'agree_to_terms'=>true,
                'esign_consent'=>true,
                'reserved_from_ip_address'=>'test ip address'],
            ['title'=>'Test Pool Room 3',
                'reservable_id'=> 2,
                'size'=> 10,
                'date'=> '2019-05-30',
                'timeslot_id'=>15,
                'event_type_id'=>2,
                'user_id'=>1,
                'agree_to_terms'=>true,
                'esign_consent'=>true,
                'reserved_from_ip_address'=>'test ip address'],
            ['title'=>'Test Pool Room 4',
                'reservable_id'=> 2,
                'size'=> 10,
                'date'=> '2019-05-30',
                'timeslot_id'=>16,
                'event_type_id'=>2,
                'user_id'=>1,
                'agree_to_terms'=>true,
                'esign_consent'=>true,
                'reserved_from_ip_address'=>'test ip address'],
            ['title'=>'Test Theater Room 1',
                'reservable_id'=> 3,
                'size'=> 10,
                'date'=> '2019-05-30',
                'timeslot_id'=>18,
                'event_type_id'=>2,
                'user_id'=>1,
                'agree_to_terms'=>true,
                'esign_consent'=>true,
                'reserved_from_ip_address'=>'test ip address'],
            ['title'=>'Test Theater Room 2',
                'reservable_id'=> 3,
                'size'=> 10,
                'date'=> '2019-05-30',
                'timeslot_id'=>19,
                'event_type_id'=>2,
                'user_id'=>1,
                'agree_to_terms'=>true,
                'esign_consent'=>true,
                'reserved_from_ip_address'=>'test ip address'],
            ['title'=>'Test Theater Room 3',
                'reservable_id'=> 3,
                'size'=> 10,
                'date'=> '2019-05-30',
                'timeslot_id'=>20,
                'event_type_id'=>2,
                'user_id'=>1,
                'agree_to_terms'=>true,
                'esign_consent'=>true,
                'reserved_from_ip_address'=>'test ip address']
        ];

        DB::table('events')->insert($events);
    }
}
