<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User admin
        DB::table('users')->insert([
            'nama'              => 'Admin',
            'alamat'            => 'Jl. Merdeka No. 10, Jakarta',
            'telepon'           => '081234567890',
            'email'             => 'admin@gmail.com',
            'email_verified_at' => now(),
            'role'              => 'admin',
            'password'          => Hash::make('admin123'),
        ]);

        // User member
        DB::table('users')->insert([
            'nama'              => 'Member',
            'alamat'            => 'Jl. Kenanga No. 5, Bandung',
            'telepon'           => '081298765432',
            'email'             => 'member@gmail.com',
            'email_verified_at' => null,
            'role'              => 'member',
            'password'          => Hash::make('member123'),
        ]);
    }
}