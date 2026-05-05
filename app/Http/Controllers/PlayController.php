<?php

namespace App\Http\Controllers;

use App\Models\Rom;
use App\Models\UserSettings;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PlayController extends Controller
{
    public function index(Request $request): Response
    {
        $requestedSlug = $request->string('game')->toString();

        $roms = Rom::query()
            ->with('emulator:id,wasm_path')
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
                'emulator_id',
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
        $selectedRomModel = Rom::query()
            ->with('emulator:id,wasm_path')
            ->where('is_public', true)
            ->when($selectedRom['slug'] ?? null, fn ($query, $slug) => $query->where('slug', $slug))
            ->first();

        return Inertia::render('Play', [
            'roms' => $roms,
            'selectedRom' => $selectedRom,
            'emulatorReady' => $selectedRomModel ? $this->emulatorBundleExists($selectedRomModel) : false,
            'romsPath' => storage_path('app/private/roms'),
        ]);
    }

    public function emulator(Request $request, Rom $rom)
    {
        abort_unless($rom->is_public, 404);

        $rom->loadMissing('emulator:id,wasm_path');
        $emulatorIndexPath = $this->emulatorIndexPath($rom);
        $emulatorIndexUrl = $this->emulatorIndexUrl($rom);
        $romUrl = route('roms.stream', ['rom' => $rom->slug]);

        return response()->view('emulator', [
            'rom' => $rom,
            'emulatorReady' => file_exists($emulatorIndexPath),
            'emulatorIndexUrl' => $emulatorIndexUrl.'?rom='.rawurlencode($romUrl),
            'romUrl' => $romUrl,
            'emulatorPreferences' => UserSettings::resolveEmulatorPreferences($request->user()?->config),
            'backgroundPresets' => UserSettings::backgroundPresets(),
            'activeTheme' => UserSettings::resolveThemeConfig($request->user()?->config),
            'profileUrl' => route('profile.edit'),
        ]);
    }

    public function updatePreferences(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'audio_volume' => ['required', 'integer', 'min:0', 'max:100'],
            'emulator_background' => ['required', 'string', Rule::in(array_keys(UserSettings::backgroundPresets()))],
            'theme' => ['sometimes', 'string', Rule::in(UserSettings::themeOptions())],
            'custom_palette' => ['nullable', 'array'],
            'custom_palette.background' => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'custom_palette.surface' => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'custom_palette.text' => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'custom_palette.accent' => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'custom_palette.secondary' => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ]);

        $settings = UserSettings::persistEmulatorPreferences($request->user()->id, $validated);

        return response()->json([
            'success' => true,
            'settings' => [
                'audio_volume' => (int) $settings->audio_volume,
                'emulator_background' => UserSettings::resolveEmulatorPreferences($settings)['emulator_background'],
                'theme' => UserSettings::resolveTheme($settings),
                'custom_palette' => UserSettings::resolveCustomPalette($settings),
            ],
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

    private function emulatorBundleExists(Rom $rom): bool
    {
        return file_exists($this->emulatorIndexPath($rom));
    }

    private function emulatorIndexPath(Rom $rom): string
    {
        return public_path($this->emulatorRelativePath($rom).'/index.html');
    }

    private function emulatorIndexUrl(Rom $rom): string
    {
        return asset($this->emulatorRelativePath($rom).'/index.html');
    }

    private function emulatorRelativePath(Rom $rom): string
    {
        $wasmPath = $rom->emulator?->wasm_path ?: 'emulator/gbajs2';
        $normalized = ltrim($wasmPath, '/');

        if (str_starts_with($normalized, 'public/')) {
            $normalized = substr($normalized, 7);
        }

        return trim($normalized, '/');
    }
}
