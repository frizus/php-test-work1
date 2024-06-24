<?php

namespace App\Providers;

use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('files', fn(Application $app) => new \App\Services\Filesystem());
        FilamentView::registerRenderHook(
            PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE,
            fn (): View => view('users-list')
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(\Spatie\Permission\Models\Permission::class, PermissionPolicy::class);
        Gate::policy(\Spatie\Permission\Models\Role::class, RolePolicy::class);
    }
}
