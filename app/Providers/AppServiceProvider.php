<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

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
        View::composer('layouts.admin', function ($view) {
            $forgot = DB::table('user')->where('reset_request', 1)->count();
            $feedback = DB::table('coursefeedback')->count();
            $announcements = DB::table('announcements')->where('status', 'pending')->count();

            $view->with([
                'forgotRequests' => $forgot,
                'feedbackCount' => $feedback,
                'announcementReview' => $announcements,
                'totalNotifications' => $forgot + $feedback + $announcements
            ]);
        });
    }
}