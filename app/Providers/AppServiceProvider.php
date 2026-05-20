<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Schema; // Import Schema facade to safely check table existence
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * bootstrap any application services.
     */
    public function boot(): void
    {
        // Fix for giant pagination arrows
        Paginator::useBootstrapFive();

        // force HTTPS if in production OR if on Railway
        if (app()->environment('production') || env('RAILWAY_ENVIRONMENT')) {
            URL::forceScheme('https');
        }

        //existing admin layout notifications
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

        //learner layout notifications
        View::composer('layouts.open_layout', function ($view) {
            $activeAnnouncementsCount = 0;

            // Only run query if the table exists to avoid migration errors
            if (Schema::hasTable('announcements')) {
                $activeAnnouncementsCount = DB::table('announcements')
                    ->where('status', 'Available')
                    ->count();
            }

            $view->with([
                'activeAnnouncementsCount' => $activeAnnouncementsCount
            ]);
        });
    }
}