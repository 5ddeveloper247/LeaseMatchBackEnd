<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@example.com'], // prevent duplicates
            [
                'type' => 1, // superAdmin
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'phone_number' => '03000000000',
                'password' => Hash::make('Admin@123'),
                'status' => 1,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
