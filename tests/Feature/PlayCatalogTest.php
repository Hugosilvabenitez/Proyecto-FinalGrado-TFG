<?php

use App\Models\Emulator;
use App\Models\Rom;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Inertia\Testing\AssertableInertia as Assert;

it('shows the closed catalog and selects the requested game', function () {
    $user = User::factory()->create();
    $emulator = Emulator::create([
        'name' => 'GBA.js 2',
        'version' => '1.0',
        'wasm_path' => 'public/emulator/gbajs2',
        'is_active' => true,
    ]);

    File::ensureDirectoryExists(storage_path('app/private/roms'));
    File::put(storage_path('app/private/roms/pokemon-firered.gba'), 'rom-data');

    $selected = Rom::create([
        'title' => 'Pokemon FireRed',
        'slug' => 'pokemon-firered',
        'description' => 'Demo catalog game.',
        'file_path' => 'roms/pokemon-firered.gba',
        'region' => 'USA',
        'emulator_id' => $emulator->id,
        'is_public' => true,
    ]);

    Rom::create([
        'title' => 'Metroid Fusion',
        'slug' => 'metroid-fusion',
        'description' => 'Second catalog game.',
        'file_path' => 'roms/metroid-fusion.gba',
        'region' => 'USA',
        'emulator_id' => $emulator->id,
        'is_public' => true,
    ]);

    $this
        ->actingAs($user)
        ->get(route('play', ['game' => $selected->slug]))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Play')
            ->where('selectedRom.slug', 'pokemon-firered')
            ->where('selectedRom.is_installed', true)
            ->where('selectedRom.launch_url', route('emulator.launch', ['rom' => 'pokemon-firered']))
            ->has('roms', 2)
            ->where('roms.0.launch_url', null)
        );
});

it('streams an installed rom file through the protected route', function () {
    $user = User::factory()->create();
    $emulator = Emulator::create([
        'name' => 'GBA.js 2',
        'version' => '1.0',
        'wasm_path' => 'public/emulator/gbajs2',
        'is_active' => true,
    ]);

    File::ensureDirectoryExists(storage_path('app/private/roms'));
    File::put(storage_path('app/private/roms/test-game.gba'), 'test-rom-content');

    $rom = Rom::create([
        'title' => 'Test Game',
        'slug' => 'test-game',
        'description' => 'Streamable game.',
        'file_path' => 'roms/test-game.gba',
        'region' => 'USA',
        'emulator_id' => $emulator->id,
        'is_public' => true,
    ]);

    $response = $this
        ->actingAs($user)
        ->get(route('roms.stream', ['rom' => $rom->slug]));

    $response->assertOk();
    $response->assertHeader('content-type', 'application/octet-stream');
    expect($response->streamedContent())->toBe('test-rom-content');
});

it('shows the fallback emulator page when the emulator bundle is missing', function () {
    $user = User::factory()->create();
    $emulator = Emulator::create([
        'name' => 'GBA.js 2',
        'version' => '1.0',
        'wasm_path' => 'public/emulator/gbajs2',
        'is_active' => true,
    ]);

    $rom = Rom::create([
        'title' => 'Fallback Game',
        'slug' => 'fallback-game',
        'description' => 'Fallback emulator view.',
        'file_path' => 'roms/fallback-game.gba',
        'region' => 'USA',
        'emulator_id' => $emulator->id,
        'is_public' => true,
    ]);

    $this
        ->actingAs($user)
        ->get(route('emulator.launch', ['rom' => $rom->slug]))
        ->assertOk()
        ->assertSee('Faltan los archivos del emulador')
        ->assertSee('fallback-game', false);
});
