<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'), // Password hashing
            'role' => 'user',
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
