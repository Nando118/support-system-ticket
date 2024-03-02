<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Ticket;
use App\Models\User;
use App\Policies\MenuPolicy;
use App\Policies\RegularUserPolicy;
use App\Policies\TicketPolicy;
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
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('create-ticket', function (User $user) {
            return $user->role === "regular_user";
        });

        Gate::define('assign-ticket', function (User $user) {
            return $user->role === "super_admin";
        });
    }
}
