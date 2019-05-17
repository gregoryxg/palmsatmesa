<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        DB::table('users')->insert([
           ['first_name'=>'Gregory',
               'last_name'=>'Gonzalez',
               'unit_id'=>1242,
               'resident_status_id'=>1,
               'account_approved'=>true,
               'approved_by_user_id'=>1,
               'board_member'=>false,
               'administrator'=>true,
               'active'=>true,
               'gate_code'=>6956,
               'profile_picture'=>'img/headshot_uploads/1.jpg',
               'mobile_phone'=>'602-245-6956',
               'email'=>'gregory_gonzalez@sbcglobal.net',
               'password'=>bcrypt('tella100'),
               'password_expires_at'=>date('Y-m-d H:i:s', strtotime('+3 months')),
               'created_at'=>date('Y-m-d H:i:s'),
               'updated_at'=>date('Y-m-d H:i:s'),
               'email_verified_at'=>date('Y-m-d H:i:s')],
            ['first_name'=>'Elisa',
                'last_name'=>'Gonzalez',
                'unit_id'=>1242,
                'resident_status_id'=>1,
                'account_approved'=>true,
                'approved_by_user_id'=>1,
                'board_member'=>false,
                'administrator'=>false,
                'active'=>true,
                'gate_code'=>6956,
                'profile_picture'=>'img/headshot_uploads/2.jpg',
                'mobile_phone'=>'910-691-9895',
                'email'=>'elisagonzalez8842@gmail.com',
                'password'=>bcrypt('tella100'),
                'password_expires_at'=>date('Y-m-d H:i:s', strtotime('+3 months')),
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
                'email_verified_at'=>date('Y-m-d H:i:s')]
        ]);
    }
}
