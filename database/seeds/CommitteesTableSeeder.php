<?php

use Illuminate\Database\Seeder;

class CommitteesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('committees')->delete();

        $committees = [

            ['description'=>'Administration and Accounting'],
            ['description'=>'Community Events and Outreach'],
            ['description'=>'Landscape and Maintenance'],
            ['description'=>'Safety and Security'],
            ['description'=>'Website and Technical Support']
        ];

        DB::table('committees')->insert($committees);
    }
}
