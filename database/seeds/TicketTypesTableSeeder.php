<?php

use Illuminate\Database\Seeder;

class TicketTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ticket_types')->delete();

        $ticket_types = [

            ['description'=>'Administration and Accounting', 'committee_id'=>1],
            ['description'=>'Community Events and Outreach', 'committee_id'=>2],
            ['description'=>'Landscape and Maintenance', 'committee_id'=>3],
            ['description'=>'Safety and Security', 'committee_id'=>4],
            ['description'=>'Website and Technical Support', 'committee_id'=>5]
        ];

        DB::table('ticket_types')->insert($ticket_types);
    }
}
