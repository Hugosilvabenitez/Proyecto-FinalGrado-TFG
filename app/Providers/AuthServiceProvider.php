<?php
// app/Providers/AuthServiceProvider.php
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Admin bypass — tiene todos los permisos automáticamente
        Gate::before(function ($user, $ability) {
            if ($user->isAdmin()) return true;
        });

        Gate::define('admin.access',        fn($u) => $u->hasPermission('admin.access'));
        Gate::define('users.manage',        fn($u) => $u->hasPermission('users.manage'));
        Gate::define('users.ban',           fn($u) => $u->hasPermission('users.ban'));
        Gate::define('roms.manage',         fn($u) => $u->hasPermission('roms.manage'));
        Gate::define('roms.edit',           fn($u) => $u->hasPermission('roms.edit'));
        Gate::define('achievements.manage', fn($u) => $u->hasPermission('achievements.manage'));
        Gate::define('stats.view',          fn($u) => $u->hasPermission('stats.view'));
        Gate::define('reports.view',        fn($u) => $u->hasPermission('reports.view'));
        Gate::define('roms.play',           fn($u) => $u->hasPermission('roms.play'));
        Gate::define('chat.use',            fn($u) => $u->hasPermission('chat.use'));
        Gate::define('profile.view',        fn($u) => $u->hasPermission('profile.view'));
    }
}