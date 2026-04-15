<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\ChatIAController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GameSessionController;
use App\Http\Controllers\AchievementController;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB; 
use Inertia\Inertia;

// ── Pública ──────────────────────────────────────────────────────────
Route::get('/', function () {

    $topPlayers = DB::table('users')
        ->join('user_achievements', 'users.id', '=', 'user_achievements.user_id')
        ->join('achievements', 'achievements.id', '=', 'user_achievements.achievement_id')
        ->select('users.username', DB::raw('SUM(achievements.points) as total'))
        ->groupBy('users.id', 'users.username')
        ->orderByDesc('total')
        ->limit(5)
        ->get();

    $topGames = DB::table('roms')
        ->join('game_sessions', 'roms.id', '=', 'game_sessions.rom_id')
        ->select('roms.title', DB::raw('COUNT(game_sessions.id) as total'))
        ->groupBy('roms.id', 'roms.title')
        ->orderByDesc('total')
        ->limit(5)
        ->get();

    return Inertia::render('Welcome', [
        'canLogin'      => Route::has('login'),
        'canRegister'   => Route::has('register'),
        'laravelVersion'=> Application::VERSION,
        'phpVersion'    => PHP_VERSION,

        'topPlayers' => $topPlayers,
        'topGames'   => $topGames,
    ]);
});

require __DIR__.'/auth.php';

// ── Solo Admin ───────────────────────────────────────────────────────
Route::middleware(['auth', 'verified', 'permission:admin.access'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('roles', RolController::class);
    Route::post('/users/{user}/ban', [UserController::class, 'ban'])->name('users.ban');
});

// ── Admin y Moderator (roms.edit) ────────────────────────────────────
Route::middleware(['auth', 'verified', 'permission:roms.edit'])->group(function () {
    Route::get('/stats', fn() => Inertia::render('Stats'))->name('stats.index');
});

// ── Usuarios autenticados ────────────────────────────────────────────
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', fn() => Inertia::render('Dashboard'))->name('dashboard');

    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/blog',       [PostController::class, 'index'])->name('blog');
    Route::post('/posts',     [PostController::class, 'store']);
    Route::post('/comments',  [CommentController::class, 'store']);

    Route::inertia('/chat-ia', 'ChatIA')->name('chat-ia');
    Route::post('/chat-ia',   [ChatIAController::class, 'chat'])->name('chat-ia.send');

    Route::post('/game-sessions',        [GameSessionController::class, 'store'])->name('game-sessions.store');
    Route::post('/game-sessions/score',  [GameSessionController::class, 'reportScore'])->name('game-sessions.score');
    Route::get('/achievements',          [AchievementController::class, 'index'])->name('achievements.index');
});