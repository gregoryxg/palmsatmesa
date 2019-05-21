<?php

use Illuminate\Database\Seeder;

class CommitteeUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('committee_user')->delete();

        $committee_user = [
            ['user_id'=>1, 'committee_id'=>1],
            ['user_id'=>1, 'committee_id'=>2],
            ['user_id'=>1, 'committee_id'=>3],
            ['user_id'=>1, 'committee_id'=>4],
            ['user_id'=>1, 'committee_id'=>5]
        ];

        DB::table('committee_user')->insert($committee_user);
    }
}
