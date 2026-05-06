<?php

namespace App\Http\Middleware;

use App\Models\UserSettings;
use Illuminate\Http\Request;
use Inertia\Middleware;

/**
* Class HandleInertiaRequests (Middleware)
* 
* @author Hugo Silva Benitez <hsilben979@g.educaand.es>
* @date 2026-05-05
* 
* This class shares authenticated user preferences and UI theme data with all Inertia views.
*/
class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();

        if ($user) {
            $user->loadMissing([
                'roles:id,name',
                'stats:user_id,total_minutes,cloud_saves,achievements_unlocked',
                'config:'.implode(',', UserSettings::settingsSelectColumns()),
            ]);
        }

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $user ? [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'email_verified_at' => $user->email_verified_at,
                    'roles' => $user->roles,
                    'avatar_url' => $user->avatar_url,
                    'stats' => $user->stats,
                    'emulator_preferences' => UserSettings::resolveEmulatorPreferences($user->config),
                    'ui_theme' => UserSettings::resolveTheme($user->config),
                    'ui_theme_config' => UserSettings::resolveThemeConfig($user->config),
                    'custom_palette' => UserSettings::resolveCustomPalette($user->config),
                ] : null,
            ],
            'ui' => [
                'emulator_background_presets' => UserSettings::backgroundPresets(),
                'supports_emulator_background' => UserSettings::hasEmulatorBackgroundColumn(),
                'theme_presets' => UserSettings::themePresets(),
                'palette_fields' => UserSettings::paletteFields(),
                'theme_palette_defaults' => UserSettings::themePaletteDefaults(),
                'custom_theme_key' => UserSettings::CUSTOM_THEME,
            ],
        ]);
    }
}
