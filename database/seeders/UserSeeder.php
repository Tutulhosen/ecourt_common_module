<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'মোঃ শামছুজ্জামান খান',
            'username' => 'samsozzaman',
            'role_id' => 2,
            'office_id' => 2,
            'is_cdap_user' => 0,
            'doptor_user_flag' => 0,
            'doptor_user_active' => 0,
            'peshkar_active' => 0,
            'peshkar_active' => 0,
            'email' =>'admin@a2i.gov.bd',
            'is_verified_account' =>0,
            'password' => Hash::make('12345678'),
        ]);
    }
}
