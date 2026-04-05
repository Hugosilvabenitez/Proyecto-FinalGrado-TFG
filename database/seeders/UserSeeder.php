<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        DB::table('users')->insert([
        [
        'name' => 'admin',
        'email' => 'admin@example.com',
        'password' => Hash::make('admin123'),
        'email_verified_at' => now(),
        'avatar_url' => 'https://api.dicebear.com/9.x/fun-emoji/svg'
        ],
        [
        'name' => 'hugo',
        'email' => 'hugo@example.com',
        'password' => Hash::make('hugo123'),
        'email_verified_at' => now(),
        'avatar_url' => 'https://api.dicebear.com/9.x/fun-emoji/svg'
        ],
        [
        'name' => 'miguel',
        'email' => 'miguel@example.com',
        'password' => Hash::make('miguel123'),
        'email_verified_at' => now(),
        'avatar_url' => 'https://api.dicebear.com/9.x/fun-emoji/svg'
        ],
        [
        'name' => 'guti',
        'email' => 'guti@example.com',
        'password' => Hash::make('guti123'),
        'email_verified_at' => now(),
        'avatar_url' => 'https://api.dicebear.com/9.x/fun-emoji/svg'
        ]
        ]);
    }
}
