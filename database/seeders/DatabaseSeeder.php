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
        'name' => 'admin',
        'email' => 'admin@example.com',
        'avatar_url' => 'null',
        'password' => Hash::make('admin123'),
        'email_verified_at' => now(),
        ],
        [
        'name' => 'hugo',
        'email' => 'hugo@example.com',
        'avatar_url' => 'null',
        'password' => Hash::make('hugo123'),
        'email_verified_at' => now(),
        ],
        [
        'name' => 'miguel',
        'email' => 'miguel@example.com',
        'avatar_url' => 'null',
        'password' => Hash::make('miguel123'),
        'email_verified_at' => now(),
        ],
        [
        'name' => 'guti',
        'email' => 'guti@example.com',
        'avatar_url' => 'null',
        'password' => Hash::make('guti123'),
        'email_verified_at' => now(),
        ]
        ]);
    }
}
