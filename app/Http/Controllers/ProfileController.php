<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\UserSettings;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

/**
* Class ProfileController (Controller)
* 
* @author Hugo Silva Benitez <hsilben979@g.educaand.es>
* @date 2026-05-05
* 
* This class manages the profile screen, account updates, and emulator preference settings.
*/
class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        $request->user()->loadMissing('config');

        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'emulatorPreferences' => UserSettings::resolveEmulatorPreferences($request->user()->config),
            'backgroundPresets' => UserSettings::backgroundPresets(),
            'supportsEmulatorBackground' => UserSettings::hasEmulatorBackgroundColumn(),
            'themePresets' => UserSettings::themePresets(),
            'selectedTheme' => UserSettings::resolveTheme($request->user()->config),
            'customPalette' => UserSettings::resolveCustomPalette($request->user()->config),
            'paletteFields' => UserSettings::paletteFields(),
            'themePaletteDefaults' => UserSettings::themePaletteDefaults(),
            'customThemeKey' => UserSettings::CUSTOM_THEME,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Update the user's emulator preferences.
     */
    public function updateEmulatorPreferences(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'audio_volume' => ['required', 'integer', 'min:0', 'max:100'],
            'theme' => ['sometimes', 'string', Rule::in(UserSettings::themeOptions())],
            'emulator_background' => ['required', 'string', Rule::in(array_keys(UserSettings::backgroundPresets()))],
            'custom_palette' => ['nullable', 'array'],
            'custom_palette.background' => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'custom_palette.surface' => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'custom_palette.text' => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'custom_palette.accent' => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'custom_palette.secondary' => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ]);

        UserSettings::persistEmulatorPreferences($request->user()->id, $validated);

        return Redirect::route('profile.edit')->with('status', 'emulator-preferences-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
