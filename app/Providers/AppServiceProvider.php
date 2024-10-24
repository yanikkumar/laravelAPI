<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
        JsonResource::withoutWrapping();
        Gate::define('view', function (User $user, $model) {
            return $user->hasAccess("view_{$model}") || $user->hasAccess("edit_{$model}");
        });
        Gate::define('edit', function (User $user, $model) {
            return $user->hasAccess("edit_{$model}");
        });
    }
}
