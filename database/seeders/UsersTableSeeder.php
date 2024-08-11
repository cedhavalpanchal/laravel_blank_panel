<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert an admin user
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'pdpanchalmec@gmail.com',
                'password' => Hash::make('123123'), // You can replace 'password' with the desired password
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
