<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SaveStorageVersionSeeder extends Seeder
{
    public function run(): void
    {
        $versionPath = storage_path('app/emulator_save_version.txt');
        File::ensureDirectoryExists(dirname($versionPath));
        File::put($versionPath, (string) Str::uuid());
    }
}
