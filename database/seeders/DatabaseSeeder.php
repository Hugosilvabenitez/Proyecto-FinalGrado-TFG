<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
   public function run(): void
    {
        DB::table('users')->insert([
        [
        'username' => 'admin',
        'email' => 'admin@example.com',
        'password' => Hash::make('admin123'),
        'email_verified_at' => now(),
        ],
        [
        'username' => 'hugo',
        'email' => 'hugo@example.com',
        'password' => Hash::make('hugo123'),
        'email_verified_at' => now(),
        ],
        [
        'username' => 'miguel',
        'email' => 'miguel@example.com',
        'password' => Hash::make('miguel123'),
        'email_verified_at' => now(),
        ],
        [
        'username' => 'guti',
        'email' => 'guti@example.com',
        'password' => Hash::make('guti123'),
        'email_verified_at' => now(),
        ]
        ]);
    }
}
