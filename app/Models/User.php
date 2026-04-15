<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class User (Model)
 *
 * @author Miguel Gordon Jiménez <mgorjim1003@g.educaand.es>
 * @date 2026-03-09
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar_url',
        'email_verified_at',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    /**
     * ONE USER CAN HAVE MANY ROLES
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    /**
     * ONE USER CAN HAVE MANY PARTIES SAVED
     */
    public function saveStates(): HasMany
    {
        return $this->hasMany(SaveState::class);
    }

    /**
     * ONE USER HAVE ONE CONFIGURATION
     */
    public function config(): HasOne
    {
        return $this->hasOne(UserSettings::class);
    }

    /**
     * ONE USER CAN GENERATE MANY LOGS
     */
    public function logs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }

    /**
     * ONE USER CAN UPLOAD MANY ROMS
     */
    public function roms(): HasMany
    {
        return $this->hasMany(Rom::class, 'uploaded_by');
    }

    /**
     * ONE USER CAN HAVE MANY ACHIEVEMENTS
     */
    public function achievements(): BelongsToMany
    {
        return $this->belongsToMany(Achievement::class, 'user_achievements')
                    ->withPivot('unlocked_at')
                    ->withTimestamps();
    }

    /**
     * ONE USER CAN HAVE MANY GAME SESSIONS
     */
    public function gameSessions(): HasMany
    {
        return $this->hasMany(GameSession::class);
    }

    // ── Helpers de estadísticas ──────────────────────────────────────

    public function totalMinutesPlayed(): int
    {
        return $this->gameSessions()->sum('minutes_played');
    }

    public function gamesCompleted(): int
    {
        return $this->gameSessions()->where('completed', true)->count();
    }

    public function stats(): HasOne
    {
        return $this->hasOne(UserStat::class);
    }

    /**
     * CREATE USER'S STATS AT HIS REGISTRATION 
     */
    protected static function booted()
    {
        static::created(function ($user) {
            $user->stats()->create([
                'total_minutes' => 0,
                'cloud_saves' => 0,
                'achievements_unlocked' => 0
            ]);
        });
    }

    // ── Helpers de roles y permisos ──────────────────────────────────

    public function hasRole(string $role): bool
    {
        return $this->roles()->where('name', $role)->exists();
    }

    public function hasPermission(string $slug): bool
    {
        return $this->roles()
            ->with('permissions')
            ->get()
            ->flatMap(fn($role) => $role->permissions)
            ->pluck('slug')
            ->contains($slug);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('Admin');
    }

    public function isModerator(): bool
    {
        return $this->hasRole('Moderator');
    }
}
