<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AchievementService;

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

        $service->check($user, 'time_played');

        return response()->json(['success' => true]);
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

    public function saveGame(AchievementService $service)
    {
        $user = auth()->user();

        $user->stats->increment('cloud_saves');

        $service->check($user, 'games_completed');

        return response()->json(['success' => true]);
    }

    //CONTINUAR POR AQUÍ CON HUGO - FALTA NOTIFICACIÓN, EVENTO Y FRONTEND

}
