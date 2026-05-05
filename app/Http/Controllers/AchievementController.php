<?php
namespace App\Http\Controllers;
use Inertia\Inertia;


/**
* Class AchievementController (Controller)
* 
* @author Hugo Silva Benitez <hsilben979@g.educaand.es>
* @date 2026-05-05
* 
* This class loads the authenticated user's achievements and prepares them for the achievements view.
*/
class AchievementController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $unlocked = $user->achievements()
            ->withPivot('unlocked_at')
            ->get()
            ->keyBy('id');

        $all = \App\Models\Achievement::all()->map(function ($achievement) use ($unlocked) {
            $pivot = $unlocked->get($achievement->id)?->pivot;

            return [
                'id' => $achievement->id,
                'name' => $achievement->name,
                'description' => $achievement->description,
                'icon' => $achievement->icon ?? null,
                'points' => $achievement->points ?? null,
                'unlocked' => $unlocked->has($achievement->id),
                'unlocked_at' => $pivot?->unlocked_at,
            ];
        })->values();

        return Inertia::render('Achievements', [
            'achievements' => $all
        ]);
    }
}
