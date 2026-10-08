<?php

namespace App\Providers;

use App\Models\ActivityLog;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

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
        /*
         * =========================
         * LOGIN
         * =========================
         */
        Event::listen(Login::class, function (Login $event): void {
            ActivityLog::create([
                'user_id' => $event->user->id,
                'action' => 'login',
                'subject_type' => $event->user::class,
                'subject_id' => $event->user->id,
                'description' => "Login User {$event->user->name}",
                'old_values' => null,
                'new_values' => null,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        });

        /*
         * =========================
         * LOGOUT
         * =========================
         */
        Event::listen(Logout::class, function (Logout $event): void {
            ActivityLog::create([
                'user_id' => $event->user?->id,
                'action' => 'logout',
                'subject_type' => $event->user ? $event->user::class : null,
                'subject_id' => $event->user?->id,
                'description' => $event->user
                    ? "Logout User {$event->user->name}"
                    : 'Logout User',
                'old_values' => null,
                'new_values' => null,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        });
    }
}