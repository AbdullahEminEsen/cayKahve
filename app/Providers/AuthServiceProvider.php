<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
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
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('edit-order', function ($user, $order) {
            // Allow users with role_id = 1 to edit any order
            if ($user->role_id === 1) {
                return true;
            }

            // Allow users with role_id = 3 to edit their own orders
            if ($user->role_id === 3 && $user->id === $order->user_id) {
                return true;
            }

            return false; // Deny editing for role_id = 2 and others
        });
    }
}
