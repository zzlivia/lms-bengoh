<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

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
        URL::forceScheme('https'); // 👈 ADD THIS LINE

        View::composer('layouts.admin_layout', function ($view) {
            $forgot = DB::table('users')->where('must_change_password', 1)->count();

            $feedback = DB::table('coursefeedback')
                ->where('is_reviewed', 0)
                ->count();

            $announcements = DB::table('announcements')
                ->where('status', 'pending')
                ->count();

            $view->with([
                'forgotRequests' => $forgot,
                'feedbackCount' => $feedback,
                'announcementReview' => $announcements,
                'totalNotifications' => $forgot + $feedback + $announcements
            ]);
        });
    }
}