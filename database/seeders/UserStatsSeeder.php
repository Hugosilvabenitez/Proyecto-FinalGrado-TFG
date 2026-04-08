<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserStat;

/**
* Class UserStatsSeeder (Seeder)
* 
* @author Miguel Gordon Jiménez <mgorjim1003@g.educaand.es>
* @date 2026-04-08
* 
* This class contains all the necessary functions for the UserStatsSeeder's data.
*/

class UserStatsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        UserStat::insert([
            [
                'user_id' => 1,
                'total_minutes' => 0,
                'cloud_saves' => 0,
                'achievements_unlocked' => 0,
            ],
            [
                'user_id' => 2,
                'total_minutes' => 0,
                'cloud_saves' => 0,
                'achievements_unlocked' => 0,
            ],
            [
                'user_id' => 3,
                'total_minutes' => 0,
                'cloud_saves' => 0,
                'achievements_unlocked' => 0,
            ]
        ]);
    }
}
