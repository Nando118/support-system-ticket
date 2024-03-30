<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Log;
use App\Models\Ticket;
use App\Models\User;
use App\Policies\LogPolicy;
use App\Policies\TicketPolicy;
use App\Policies\UserPolicy;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Ticket::class => TicketPolicy::class,
        User::class => UserPolicy::class,
        Log::class => LogPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('create-new-ticket', function (User $user) {
            if ($user->isRegular()) {
                return true;
            }
            return false;
        });

        Gate::define('assign-ticket', function (User $user) {
            if ($user->isAdmin()) {
                return true;
            }
            return false;
        });

        Gate::define('view-users', function (User $user) {
            if ($user->isAdmin()) {
                return true;
            }
            return false;
        });

        Gate::define('view-logs', function (User $user) {
            if ($user->isAdmin()) {
                return true;
            }
            return false;
        });
    }
}
