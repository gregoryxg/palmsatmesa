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
                'ticket_type_id'=>1,
                'created_at'=>date('Y-m-d H:i:s')],
            ['subject'=>'Community Events and Outreach Subject',
                'body'=>'Community Events and Outreach Subject Body Text',
                'ticket_type_id'=>2,
                'created_at'=>date('Y-m-d H:i:s')],
            ['subject'=>'Landscape and Maintenance Subject',
                'body'=>'Landscape and Maintenance Subject Body Text',
                'ticket_type_id'=>3,
                'created_at'=>date('Y-m-d H:i:s')],
            ['subject'=>'Safety and Security Subject',
                'body'=>'Safety and Security Subject Body Text',
                'ticket_type_id'=>4,
                'created_at'=>date('Y-m-d H:i:s')],
            ['subject'=>'Website and Technical Support Subject',
                'body'=>'Website and Technical Support Body Text',
                'ticket_type_id'=>5,
                'created_at'=>date('Y-m-d H:i:s')]
        ];

        DB::table('tickets')->insert($tickets);
    }
}
