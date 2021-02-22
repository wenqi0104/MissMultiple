<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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
            'name' => Str::random(10),
            'email' => Str::random(10).'@qq.com',
            'age' => Str::random(10),
            'type' => Str::random(10),
            'avatar' => 'noavatar.png',
            'password' => Hash::make('password'),
            
        ]);
    }
}
