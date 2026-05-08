<?php

namespace Database\Seeders;

use App\Models\Rom;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
/**
* Class DatabaseSeeder (Seeder)
* 
* @author Hugo Silva Benitez <hsilben979@g.educaand.es>
* @date 2026-05-05
* 
* This seeder orchestrates the execution of the application's database seeders.
*/
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
   public function run(): void
    {
        $this->call([
            UserSeeder::class,
            RolSeeder::class,
            RolUserSeeder::class,
            EmulatorSeeder::class,
            RomSeeder::class,
            UserRomSeeder::class,
            UserSettingSeeder::class,
            SaveStateSeeder::class,
            AuditLogSeeder::class,
            AchievementSeeder::class,
            PermissionSeeder::class,
            UserStatsSeeder::class,
            SaveStorageVersionSeeder::class
        ]);
    }
}
