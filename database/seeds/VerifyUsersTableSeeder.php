<?php

use Illuminate\Database\Seeder;

class VerifyUsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('verify_users')->delete();
        
        \DB::table('verify_users')->insert(array (
            0 => 
            array (
                'user_id' => 1,
                'token' => '7a3a13bf04a1ef47e3290e8a9577f38fb5790c6e',
                'expires_at' => '2019-05-30 11:27:35',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'user_id' => 2,
                'token' => '7a3a13bf04a1ef47e3290e8a9577f38fb5790c6e',
                'expires_at' => '2019-05-30 11:27:35',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}