<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AchievementService;
use App\Models\Rom;
use App\Models\SaveState;

/**
* Class UserStatsController (Controller)
* 
* @author Miguel Gordon Jiménez <mgorjim1003@g.educaand.es>
* @date 2026-04-13
* 
* This file contains all the necessary functions for the User's stats.
*/

class UserStatsController extends Controller
{
    public function addPlayTime(Request $request, AchievementService $service)
    {
        $user = auth()->user();

        $user->stats->increment('total_minutes', $request->minutes);

        $unlocked = $service->check($user, 'time_played');

        return response()->json([
            'success' => true,
            'achievements' => $unlocked
        ]);
    }

    public function addCloudSave()
    {
        $user = auth()->user();
        $user->stats->increment('cloud_saves');

        return response()->json(['success' => true]);
    }

    public function addAchievement()
    {
        $user = auth()->user();
        $user->stats->increment('achievements_unlocked');

        return response()->json(['success' => true]);
    }

    public function registerCloudSave(Request $request)
    {
        $data = $request->validate([
            'rom_id' => ['required', 'integer', 'exists:roms,id'],
            'slot_number' => ['nullable', 'integer', 'min:1', 'max:99'],
            'save_key' => ['required', 'string', 'max:255', 'starts_with:com.endrift.gbajs.user.'],
        ]);

        $user = auth()->user();
        $rom = Rom::query()->findOrFail($data['rom_id']);
        $slotNumber = $data['slot_number'] ?? 1;

        $saveState = SaveState::query()->updateOrCreate(
            [
                'user_id' => $user->id,
                'rom_id' => $rom->id,
                'slot_number' => $slotNumber,
            ],
            [
                'save_name' => $rom->title.' - Slot '.$slotNumber,
                'save_path' => $data['save_key'],
            ]
        );

        if ($saveState->wasRecentlyCreated) {
            $user->stats()->firstOrCreate()->increment('cloud_saves');
        }

        return response()->json([
            'success' => true,
            'save_state' => $saveState,
        ]);
    }

    public function saveGame(AchievementService $service)
    {
        $user = auth()->user();

        $user->stats->increment('cloud_saves');

        $service->check($user, 'games_completed');

        return response()->json(['success' => true]);
    }

}
