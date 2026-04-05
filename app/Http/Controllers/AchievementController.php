<?php
// app/Http/Controllers/AchievementController.php
namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class AchievementController extends Controller
{
    public function index(): JsonResponse
    {
        $user = auth()->user();

        $unlocked = $user->achievements()
            ->withPivot('unlocked_at')
            ->get()
            ->keyBy('id');

        $all = \App\Models\Achievement::all()->map(function ($achievement) use ($unlocked) {
            $achievement->unlocked    = $unlocked->has($achievement->id);
            $achievement->unlocked_at = $unlocked->get($achievement->id)?->pivot->unlocked_at;
            return $achievement;
        });

        return response()->json($all);
    }
}