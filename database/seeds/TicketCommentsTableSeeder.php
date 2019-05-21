<?php

use Illuminate\Database\Seeder;

class TicketCommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ticket_comments')->delete();

        $ticket_comments = [

            ['comment'=>'Administration and Accounting Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.',
                'ticket_id'=>1,
                'user_id'=>1,
                'created_at'=>date('Y-m-d H:i:s')],
            ['comment'=>'Administration and Accounting Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.',
                'ticket_id'=>1,
                'user_id'=>2,
                'created_at'=>date('Y-m-d H:i:s')],
            ['comment'=>'Community Events and Outreach TicketComment',
                'ticket_id'=>2,
                'user_id'=>1,
                'created_at'=>date('Y-m-d H:i:s')],
            ['comment'=>'Landscape and Maintenance TicketComment',
                'ticket_id'=>3,
                'user_id'=>1,
                'created_at'=>date('Y-m-d H:i:s')],
            ['comment'=>'Safety and Security TicketComment',
                'ticket_id'=>4,
                'user_id'=>1,
                'created_at'=>date('Y-m-d H:i:s')],
            ['comment'=>'Website and Technical Support TicketComment',
                'ticket_id'=>5,
                'user_id'=>1,
                'created_at'=>date('Y-m-d H:i:s')]
        ];

        DB::table('ticket_comments')->insert($ticket_comments);
    }
}
