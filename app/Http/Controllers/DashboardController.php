<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

/**
* Class DashboardController (Controller)
* 
* @author Miguel Gordon Jiménez <mgorjim1003@g.educaand.es>
* @date 2026-04-08
* 
* This class contains all the necessary functions for the Dashboard's data.
*/

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load('stats');

        $savedGames = $user->saveStates()
            ->with('rom:id,title,slug,cover_image,region')
            ->where('save_path', 'like', 'com.endrift.gbajs.user.%')
            ->latest('updated_at')
            ->get()
            ->map(fn ($saveState) => [
                'id' => $saveState->id,
                'save_name' => $saveState->save_name,
                'slot_number' => $saveState->slot_number,
                'updated_at' => $saveState->updated_at?->toISOString(),
                'rom' => [
                    'id' => $saveState->rom?->id,
                    'title' => $saveState->rom?->title ?? 'Juego no disponible',
                    'slug' => $saveState->rom?->slug,
                    'cover_image' => $saveState->rom?->cover_image,
                    'region' => $saveState->rom?->region,
                    'play_url' => $saveState->rom?->slug
                        ? route('play', ['game' => $saveState->rom->slug])
                        : route('play'),
                ],
            ])
            ->values();

        return Inertia::render('Dashboard', [
            'auth' => [
                'user' => $user
            ],
            'savedGames' => $savedGames,
        ]);
    }
}
