<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('users')->insert([
                'name' => 'PRTIMES'.$i,
                'email' => 'prtimes'.$i.'@gmail.com',
                'address' => '株式会社 PR TIMES',
                'password' => Hash::make('qwe123'),
                'created_at' => Carbon::now()
            ]);
        }
    }
}
