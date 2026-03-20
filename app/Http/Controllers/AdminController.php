<?php

namespace App\Http\Controllers;

//import models
use App\Models\LearningMaterials;
use App\Models\Users;
use App\Models\Course;
use App\Models\Module;
use App\Models\Lecture;
use App\Models\Progress;
use App\Models\Announcements;
use App\Models\Feedback;

//laravel utilities
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function admin_dashboard()
    {
        // 1. High-Level Stats (KPIs)
        $stats = [
            'totalUsers'    => Users::count(),
            'totalCourses'  => Course::count(),
            'totalModules'  => Module::count(),
            'totalLectures' => Lecture::count(),
        ];

        // 2. Announcements & Course Popularity
        $announcements = Announcements::latest()->take(4)->get();

        $courseStats = DB::table('enrolmentcoursemodules')
            ->join('course', 'enrolmentcoursemodules.courseID', '=', 'course.courseID')
            ->select('course.courseName', DB::raw('COUNT(DISTINCT enrolmentcoursemodules.userID) as total'))
            ->groupBy('course.courseName')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        // 3. Resource Summary
        $recentMaterial = DB::table('learningmaterials')->latest()->first();
        
        // Helper to avoid repeating join logic for PDFs and Videos
        $getLatestByType = function($table) {
            return DB::table($table)
                ->join('learningmaterials', "$table.learningMaterialID", "=", "learningmaterials.learningMaterialID")
                ->select('learningmaterials.learningMaterialTitle')
                ->orderByDesc('learningmaterials.created_at')
                ->first();
        };

        $recentPdf = $getLatestByType('pdflearning');
        $recentVideo = $getLatestByType('videolearning');
        $unusedMaterials = DB::table('learningmaterials')->whereNull('lectID')->count();

        // 4. Data for Charts & Notifications
        $chartData = [
            'completedModules' => DB::table('enrolmentcoursemodules')->where('isCompleted', 1)->count(),
            'pdfMaterials'     => DB::table('pdflearning')->count(),
            'videoMaterials'   => DB::table('videolearning')->count(),
        ];

        $notifications = [
            'forgotRequests'     => Users::where('reset_request', 1)->count(),
            'feedbackCount'      => DB::table('coursefeedback')->count(),
            'announcementReview' => Announcements::where('status', 'pending')->count(),
        ];

        $totalNotifications = array_sum($notifications);

        //merge all variables into the view
        return view('admin.admin_dashboard', array_merge(
            $stats, 
            $chartData, 
            $notifications, 
            compact('announcements', 'courseStats', 'recentMaterial', 'recentPdf', 'recentVideo', 'unusedMaterials', 'totalNotifications')
        ));
    }
}
