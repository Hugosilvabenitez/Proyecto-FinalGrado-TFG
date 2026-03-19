<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class UserSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    DB::table('user_settings')->insert([
        [
            'user_id' => 1,
            'control_config' => null,
            'audio_volume' => 80,
            'video_scale' => 2,
            'theme' => 'dark',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'user_id' => 2,
            'control_config' => null,
            'audio_volume' => 80,
            'video_scale' => 2,
            'theme' => 'light',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'user_id' => 3,
            'control_config' => null,
            'audio_volume' => 80,
            'video_scale' => 2,
            'theme' => 'dark',
            'created_at' => now(),
            'updated_at' => now()
        ]
    ]);
}
}
