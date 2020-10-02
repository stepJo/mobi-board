<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'u_name'     => 'Stephen',
            'u_email'    => 'stepjodevtest1@gmail.com',
            'u_password' => Hash::make('12345678')
        ]);
    }
}
