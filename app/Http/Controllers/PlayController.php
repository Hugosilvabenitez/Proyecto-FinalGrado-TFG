<?php

namespace App\Http\Controllers;

use App\Models\Rom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PlayController extends Controller
{
    public function index(Request $request): Response
    {
        $requestedSlug = $request->string('game')->toString();
        $emulatorReady = file_exists(public_path('emulator/gbajs2/index.html'));

        $roms = Rom::query()
            ->where('is_public', true)
            ->orderBy('title')
            ->get([
                'id',
                'title',
                'slug',
                'description',
                'file_path',
                'cover_image',
                'region',
            ])
            ->map(function (Rom $rom) {
                $isInstalled = Storage::disk('local')->exists($rom->file_path);

                return [
                    'id' => $rom->id,
                    'title' => $rom->title,
                    'slug' => $rom->slug,
                    'description' => $rom->description,
                    'region' => $rom->region,
                    'cover_image' => $rom->cover_image,
                    'file_name' => basename($rom->file_path),
                    'is_installed' => $isInstalled,
                    'launch_url' => $isInstalled ? route('emulator.launch', ['rom' => $rom->slug]) : null,
                ];
            })
            ->values();

        $selectedRom = $roms->firstWhere('slug', $requestedSlug) ?? $roms->first();

        return Inertia::render('Play', [
            'roms' => $roms,
            'selectedRom' => $selectedRom,
            'emulatorReady' => $emulatorReady,
            'romsPath' => storage_path('app/private/roms'),
        ]);
    }

    public function emulator(Rom $rom)
    {
        abort_unless($rom->is_public, 404);

        $emulatorIndexPath = public_path('emulator/gbajs2/index.html');
        $emulatorIndexUrl = asset('emulator/gbajs2/index.html');
        $romUrl = route('roms.stream', ['rom' => $rom->slug]);

        return response()->view('emulator', [
            'rom' => $rom,
            'emulatorReady' => file_exists($emulatorIndexPath),
            'emulatorIndexUrl' => $emulatorIndexUrl.'?rom='.rawurlencode($romUrl),
            'romUrl' => $romUrl,
        ]);
    }

    public function stream(Rom $rom): StreamedResponse
    {
        abort_unless($rom->is_public, 404);
        abort_unless(Storage::disk('local')->exists($rom->file_path), 404);

        return Storage::disk('local')->response(
            $rom->file_path,
            basename($rom->file_path),
            [
                'Content-Type' => 'application/octet-stream',
                'Cache-Control' => 'no-store, no-cache, must-revalidate',
            ]
        );
    }
}
