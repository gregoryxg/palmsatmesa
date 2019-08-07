<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'first_name' => 'Gregory',
                'last_name' => 'Gonzalez',
                'unit_id' => 1242,
                'resident_status_id' => 1,
                'account_approved' => 1,
                'approved_by_user_id' => 1,
                'board_member' => 0,
                'administrator' => 1,
                'active' => 1,
                'gate_code' => 6956,
                'profile_picture' => 'private/headshot_uploads/1.jpg',
                'mobile_phone' => '602-245-6956',
                'home_phone' => NULL,
                'work_phone' => NULL,
                'email' => 'gregory_gonzalez@sbcglobal.net',
                'password' => '$2y$10$PNtGg2pR8pXRsZ1CW80sJedZigWOs/zJOZh1VhgLqN2zCRvuAwfvW',
                'remember_token' => NULL,
                'created_at' => '2019-05-29 11:27:38',
                'updated_at' => '2019-05-29 11:27:38',
                'last_login_at' => NULL,
                'password_expires_at' => '2019-08-29 11:27:35',
                'email_verified_at' => '2019-05-29 11:27:38',
            ),
            1 => 
            array (
                'id' => 2,
                'first_name' => 'Elisa',
                'last_name' => 'Gonzalez',
                'unit_id' => 1242,
                'resident_status_id' => 1,
                'account_approved' => 1,
                'approved_by_user_id' => 1,
                'board_member' => 0,
                'administrator' => 0,
                'active' => 1,
                'gate_code' => 6956,
                'profile_picture' => 'private/headshot_uploads/2.jpg',
                'mobile_phone' => '910-691-9895',
                'home_phone' => NULL,
                'work_phone' => NULL,
                'email' => 'elisagonzalez8842@gmail.com',
                'password' => '$2y$10$RoxzqsSkZaPlE.5EAScZq.lzmX7n2CzMxO2WRYsVUKxelp8DVm6HO',
                'remember_token' => NULL,
                'created_at' => '2019-05-29 11:27:38',
                'updated_at' => '2019-05-29 11:27:38',
                'last_login_at' => NULL,
                'password_expires_at' => '2019-08-29 11:27:35',
                'email_verified_at' => '2019-05-29 11:27:38',
            ),
        ));
        
        
    }
}