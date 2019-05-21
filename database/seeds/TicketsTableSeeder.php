<?php

use Illuminate\Database\Seeder;

class TicketsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tickets')->delete();

        $tickets = [

            ['subject'=>'Administration and Accounting Subject',
                'body'=>'Administration and Accounting Body Text',
                'ticket_type_id'=>1],
            ['subject'=>'Community Events and Outreach Subject',
                'body'=>'Community Events and Outreach Subject Body Text',
                'ticket_type_id'=>2],
            ['subject'=>'Landscape and Maintenance Subject',
                'body'=>'Landscape and Maintenance Subject Body Text',
                'ticket_type_id'=>3],
            ['subject'=>'Safety and Security Subject',
                'body'=>'Safety and Security Subject Body Text',
                'ticket_type_id'=>4],
            ['subject'=>'Website and Technical Support Subject',
                'body'=>'Website and Technical Support Body Text',
                'ticket_type_id'=>5]
        ];

        DB::table('tickets')->insert($tickets);
    }
}
