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
use Inertia\Inertia;

// ── Pública ──────────────────────────────────────────────────────────
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin'      => Route::has('login'),
        'canRegister'   => Route::has('register'),
        'laravelVersion'=> Application::VERSION,
        'phpVersion'    => PHP_VERSION,
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
    // Dashboard
    Route::get('/dashboard', fn() => Inertia::render('Dashboard'))
        ->name('dashboard');

    // Perfil
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Blog
    Route::get('/blog',       [PostController::class, 'index'])->name('blog');
    Route::post('/posts',     [PostController::class, 'store']);
    Route::post('/comments',  [CommentController::class, 'store']);

    // Chat IA
    Route::inertia('/chat-ia', 'ChatIA')->name('chat-ia');
    Route::post('/chat-ia',   [ChatIAController::class, 'chat'])->name('chat-ia.send');

    // Sesiones de juego y logros
    Route::post('/game-sessions',        [GameSessionController::class, 'store'])->name('game-sessions.store');
    Route::post('/game-sessions/score',  [GameSessionController::class, 'reportScore'])->name('game-sessions.score');
    Route::get('/achievements',          [AchievementController::class, 'index'])->name('achievements.index');
});