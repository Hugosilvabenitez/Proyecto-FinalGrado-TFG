<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Schema;

/**
 * Class UserSettings (Model)
 *
 * @author Miguel Gordon Jiménez <mgorjim1003@g.educaand.es>
 *
 * @date 2026-03-09
 *
 * This class contains all the relationships, accessors, mutators, and fields necessary for the UserSettings model.
 */
class UserSettings extends Model
{
    protected static ?bool $hasEmulatorBackgroundColumn = null;

    public const DEFAULT_AUDIO_VOLUME = 100;

    public const DEFAULT_BACKGROUND = 'nebula';

    public const DEFAULT_THEME = 'nebula';

    public const THEME_PRESETS = [
        'nebula' => [
            'label' => 'Nebula',
            'shell_background' => 'radial-gradient(circle at top, rgba(56, 189, 248, 0.24), transparent 35%), linear-gradient(180deg, #020617 0%, #0f172a 100%)',
            'hero_background' => 'radial-gradient(circle at top right, rgba(56, 189, 248, 0.16), transparent 40%), linear-gradient(180deg, rgba(15, 23, 42, 0.88), rgba(2, 6, 23, 0.96))',
            'nav_background' => 'rgba(15, 23, 42, 0.92)',
            'panel' => 'rgba(15, 23, 42, 0.78)',
            'panel_strong' => 'rgba(2, 6, 23, 0.82)',
            'panel_soft' => 'rgba(255, 255, 255, 0.05)',
            'input_background' => 'rgba(2, 6, 23, 0.72)',
            'line' => 'rgba(255, 255, 255, 0.10)',
            'line_strong' => 'rgba(255, 255, 255, 0.18)',
            'text' => '#f8fafc',
            'muted' => '#cbd5e1',
            'subtle' => '#94a3b8',
            'accent' => '#67e8f9',
            'accent_soft' => 'rgba(34, 211, 238, 0.12)',
            'accent_border' => 'rgba(34, 211, 238, 0.32)',
            'accent_ring' => 'rgba(34, 211, 238, 0.24)',
            'secondary' => '#f472b6',
            'secondary_soft' => 'rgba(244, 114, 182, 0.12)',
            'secondary_border' => 'rgba(244, 114, 182, 0.30)',
            'secondary_ring' => 'rgba(244, 114, 182, 0.22)',
            'title_gradient' => 'linear-gradient(90deg, #67e8f9 0%, #60a5fa 52%, #f472b6 100%)',
            'button_gradient' => 'linear-gradient(90deg, #22d3ee 0%, #3b82f6 52%, #d946ef 100%)',
            'orb_primary' => 'linear-gradient(135deg, rgba(34, 211, 238, 0.85), rgba(59, 130, 246, 0.78), rgba(139, 92, 246, 0.74))',
            'orb_secondary' => 'linear-gradient(135deg, rgba(217, 70, 239, 0.70), rgba(249, 115, 22, 0.62), rgba(250, 204, 21, 0.58))',
        ],
        'sunset' => [
            'label' => 'Sunset',
            'shell_background' => 'radial-gradient(circle at top left, rgba(251, 146, 60, 0.22), transparent 32%), linear-gradient(135deg, #3f0d12 0%, #7c2d12 40%, #4c1d95 100%)',
            'hero_background' => 'radial-gradient(circle at top right, rgba(251, 146, 60, 0.14), transparent 38%), linear-gradient(180deg, rgba(76, 29, 149, 0.78), rgba(63, 13, 18, 0.94))',
            'nav_background' => 'rgba(67, 20, 7, 0.90)',
            'panel' => 'rgba(88, 28, 12, 0.72)',
            'panel_strong' => 'rgba(67, 20, 7, 0.82)',
            'panel_soft' => 'rgba(255, 237, 213, 0.06)',
            'input_background' => 'rgba(67, 20, 7, 0.72)',
            'line' => 'rgba(255, 237, 213, 0.10)',
            'line_strong' => 'rgba(254, 215, 170, 0.18)',
            'text' => '#fff7ed',
            'muted' => '#fed7aa',
            'subtle' => '#fdba74',
            'accent' => '#fb923c',
            'accent_soft' => 'rgba(251, 146, 60, 0.14)',
            'accent_border' => 'rgba(251, 146, 60, 0.34)',
            'accent_ring' => 'rgba(251, 146, 60, 0.22)',
            'secondary' => '#f9a8d4',
            'secondary_soft' => 'rgba(244, 114, 182, 0.12)',
            'secondary_border' => 'rgba(244, 114, 182, 0.26)',
            'secondary_ring' => 'rgba(244, 114, 182, 0.18)',
            'title_gradient' => 'linear-gradient(90deg, #fdba74 0%, #fb7185 48%, #c084fc 100%)',
            'button_gradient' => 'linear-gradient(90deg, #fb923c 0%, #f97316 48%, #ec4899 100%)',
            'orb_primary' => 'linear-gradient(135deg, rgba(251, 146, 60, 0.82), rgba(249, 115, 22, 0.74), rgba(244, 114, 182, 0.66))',
            'orb_secondary' => 'linear-gradient(135deg, rgba(236, 72, 153, 0.68), rgba(168, 85, 247, 0.62), rgba(251, 191, 36, 0.54))',
        ],
        'forest' => [
            'label' => 'Forest',
            'shell_background' => 'radial-gradient(circle at top right, rgba(74, 222, 128, 0.20), transparent 34%), linear-gradient(135deg, #052e16 0%, #14532d 45%, #1f2937 100%)',
            'hero_background' => 'radial-gradient(circle at top right, rgba(74, 222, 128, 0.16), transparent 40%), linear-gradient(180deg, rgba(6, 78, 59, 0.80), rgba(2, 44, 34, 0.96))',
            'nav_background' => 'rgba(6, 46, 22, 0.92)',
            'panel' => 'rgba(6, 78, 59, 0.70)',
            'panel_strong' => 'rgba(2, 44, 34, 0.84)',
            'panel_soft' => 'rgba(240, 253, 244, 0.05)',
            'input_background' => 'rgba(2, 44, 34, 0.74)',
            'line' => 'rgba(240, 253, 244, 0.10)',
            'line_strong' => 'rgba(187, 247, 208, 0.18)',
            'text' => '#f0fdf4',
            'muted' => '#dcfce7',
            'subtle' => '#86efac',
            'accent' => '#4ade80',
            'accent_soft' => 'rgba(74, 222, 128, 0.14)',
            'accent_border' => 'rgba(74, 222, 128, 0.34)',
            'accent_ring' => 'rgba(74, 222, 128, 0.22)',
            'secondary' => '#2dd4bf',
            'secondary_soft' => 'rgba(45, 212, 191, 0.12)',
            'secondary_border' => 'rgba(45, 212, 191, 0.28)',
            'secondary_ring' => 'rgba(45, 212, 191, 0.18)',
            'title_gradient' => 'linear-gradient(90deg, #86efac 0%, #4ade80 45%, #2dd4bf 100%)',
            'button_gradient' => 'linear-gradient(90deg, #4ade80 0%, #22c55e 48%, #14b8a6 100%)',
            'orb_primary' => 'linear-gradient(135deg, rgba(74, 222, 128, 0.82), rgba(34, 197, 94, 0.74), rgba(20, 184, 166, 0.62))',
            'orb_secondary' => 'linear-gradient(135deg, rgba(45, 212, 191, 0.66), rgba(59, 130, 246, 0.56), rgba(163, 230, 53, 0.48))',
        ],
        'arcade' => [
            'label' => 'Arcade',
            'shell_background' => 'radial-gradient(circle at center, rgba(168, 85, 247, 0.16), transparent 38%), linear-gradient(135deg, #111827 0%, #312e81 48%, #0f172a 100%)',
            'hero_background' => 'radial-gradient(circle at top right, rgba(168, 85, 247, 0.15), transparent 38%), linear-gradient(180deg, rgba(49, 46, 129, 0.80), rgba(15, 23, 42, 0.94))',
            'nav_background' => 'rgba(17, 24, 39, 0.94)',
            'panel' => 'rgba(30, 41, 59, 0.76)',
            'panel_strong' => 'rgba(15, 23, 42, 0.84)',
            'panel_soft' => 'rgba(255, 255, 255, 0.05)',
            'input_background' => 'rgba(15, 23, 42, 0.76)',
            'line' => 'rgba(255, 255, 255, 0.10)',
            'line_strong' => 'rgba(196, 181, 253, 0.18)',
            'text' => '#f8fafc',
            'muted' => '#e2e8f0',
            'subtle' => '#c4b5fd',
            'accent' => '#a78bfa',
            'accent_soft' => 'rgba(167, 139, 250, 0.14)',
            'accent_border' => 'rgba(167, 139, 250, 0.34)',
            'accent_ring' => 'rgba(167, 139, 250, 0.20)',
            'secondary' => '#f472b6',
            'secondary_soft' => 'rgba(244, 114, 182, 0.12)',
            'secondary_border' => 'rgba(244, 114, 182, 0.26)',
            'secondary_ring' => 'rgba(244, 114, 182, 0.18)',
            'title_gradient' => 'linear-gradient(90deg, #c4b5fd 0%, #a78bfa 45%, #f472b6 100%)',
            'button_gradient' => 'linear-gradient(90deg, #8b5cf6 0%, #6366f1 48%, #ec4899 100%)',
            'orb_primary' => 'linear-gradient(135deg, rgba(168, 85, 247, 0.76), rgba(99, 102, 241, 0.72), rgba(59, 130, 246, 0.60))',
            'orb_secondary' => 'linear-gradient(135deg, rgba(244, 114, 182, 0.62), rgba(249, 115, 22, 0.52), rgba(250, 204, 21, 0.42))',
        ],
    ];

    public const BACKGROUND_PRESETS = [
        'nebula' => [
            'label' => 'Nebula',
            'accent' => '#22d3ee',
            'css' => 'radial-gradient(circle at top, rgba(56, 189, 248, 0.24), transparent 35%), linear-gradient(180deg, #020617 0%, #0f172a 100%)',
        ],
        'sunset' => [
            'label' => 'Sunset',
            'accent' => '#fb7185',
            'css' => 'radial-gradient(circle at top left, rgba(251, 146, 60, 0.26), transparent 32%), linear-gradient(135deg, #3f0d12 0%, #8a2387 48%, #f27121 100%)',
        ],
        'forest' => [
            'label' => 'Forest',
            'accent' => '#4ade80',
            'css' => 'radial-gradient(circle at top right, rgba(74, 222, 128, 0.24), transparent 34%), linear-gradient(135deg, #052e16 0%, #14532d 45%, #1f2937 100%)',
        ],
        'arcade' => [
            'label' => 'Arcade',
            'accent' => '#a855f7',
            'css' => 'radial-gradient(circle at center, rgba(168, 85, 247, 0.16), transparent 38%), linear-gradient(135deg, #111827 0%, #312e81 48%, #0f172a 100%)',
        ],
    ];

    protected $fillable = [
        'user_id',
        'control_config',
        'audio_volume',
        'video_scale',
        'theme',
        'emulator_background',
    ];

    protected $casts = [
        'control_config' => 'array',
    ];

    public static function backgroundPresets(): array
    {
        return self::BACKGROUND_PRESETS;
    }

    public static function themePresets(): array
    {
        return self::THEME_PRESETS;
    }

    public static function hasEmulatorBackgroundColumn(): bool
    {
        if (self::$hasEmulatorBackgroundColumn !== null) {
            return self::$hasEmulatorBackgroundColumn;
        }

        return self::$hasEmulatorBackgroundColumn = Schema::hasColumn('user_settings', 'emulator_background');
    }

    public static function settingsSelectColumns(): array
    {
        $columns = [
            'id',
            'user_id',
            'audio_volume',
            'theme',
        ];

        if (self::hasEmulatorBackgroundColumn()) {
            $columns[] = 'emulator_background';
        }

        return $columns;
    }

    public static function persistEmulatorPreferences(int $userId, array $preferences): self
    {
        $payload = [
            'audio_volume' => (int) ($preferences['audio_volume'] ?? self::DEFAULT_AUDIO_VOLUME),
        ];

        if (array_key_exists('theme', $preferences)) {
            $payload['theme'] = $preferences['theme'];
        }

        if (self::hasEmulatorBackgroundColumn() && array_key_exists('emulator_background', $preferences)) {
            $payload['emulator_background'] = $preferences['emulator_background'];
        }

        return self::query()->updateOrCreate(
            ['user_id' => $userId],
            $payload,
        );
    }

    public static function resolveEmulatorPreferences(?self $settings): array
    {
        $background = self::hasEmulatorBackgroundColumn()
            ? $settings?->emulator_background
            : self::DEFAULT_BACKGROUND;

        if (! is_string($background) || ! array_key_exists($background, self::BACKGROUND_PRESETS)) {
            $background = self::DEFAULT_BACKGROUND;
        }

        return [
            'audio_volume' => (int) ($settings?->audio_volume ?? self::DEFAULT_AUDIO_VOLUME),
            'emulator_background' => $background,
        ];
    }

    public static function resolveTheme(?self $settings): string
    {
        $theme = $settings?->theme;

        if (! is_string($theme) || ! array_key_exists($theme, self::THEME_PRESETS)) {
            return self::DEFAULT_THEME;
        }

        return $theme;
    }

    /**
     * ONE SETTING BELONGS TO AN USER
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
