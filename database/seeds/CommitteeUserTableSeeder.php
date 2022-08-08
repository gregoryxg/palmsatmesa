<?php

use Illuminate\Database\Seeder;

class CommitteeUserTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('committee_user')->delete();

        \DB::table('committee_user')->insert(array (
            0 =>
            array (
                'id' => 1,
                'user_id' => 1,
                'committee_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            array (
                'id' => 2,
                'user_id' => 1,
                'committee_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            array (
                'id' => 3,
                'user_id' => 1,
                'committee_id' => 3,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            array (
                'id' => 4,
                'user_id' => 1,
                'committee_id' => 4,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            array (
                'id' => 5,
                'user_id' => 1,
                'committee_id' => 5,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            array (
                'id' => 6,
                'user_id' => 1,
                'committee_id' => 6,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            array (
                'id' => 7,
                'user_id' => 1,
                'committee_id' => 7,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            array (
                'id' => 8,
                'user_id' => 1,
                'committee_id' => 8,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            array (
                'id' => 9,
                'user_id' => 1,
                'committee_id' => 9,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            array (
                'id' => 10,
                'user_id' => 1,
                'committee_id' => 10,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        );

    }
}
