<?php
// app/Http/Controllers/GameSessionController.php
namespace App\Http\Controllers;

use App\Models\GameSession;
use App\Services\AchievementService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class GameSessionController extends Controller
{
    public function store(Request $request, AchievementService $achievements): JsonResponse
    {
        $validated = $request->validate([
            'rom_id'         => 'required|exists:roms,id',
            'minutes_played' => 'required|integer|min:1',
            'completed'      => 'boolean',
        ]);

        $session = GameSession::create([
            'user_id'        => auth()->id(),
            'rom_id'         => $validated['rom_id'],
            'minutes_played' => $validated['minutes_played'],
            'completed'      => $validated['completed'] ?? false,
            'played_at'      => now(),
        ]);

        $achievements->check(auth()->user(), 'time_played');

        if ($session->completed) {
            $achievements->check(auth()->user(), 'games_completed');
        }

        return response()->json($session, 201);
    }

    public function reportScore(Request $request, AchievementService $achievements): JsonResponse
    {
        $validated = $request->validate([
            'score' => 'required|integer|min:0',
        ]);

        $achievements->checkInGame(auth()->user(), $validated['score']);

        return response()->json(['ok' => true]);
    }
}