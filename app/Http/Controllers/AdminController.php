<?php

//handles admin panel logic
namespace App\Http\Controllers;

//import models
use App\Models\LearningMaterials;
use App\Models\User;
use App\Models\Course;
use App\Models\Module;
use App\Models\Lecture;
use App\Models\LectureSection;
use App\Models\Progress;
use App\Models\Announcements;
use App\Models\Feedback;
use App\Models\AssessmentResult;

//laravel utilities
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

//pdf generator
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function dashboard() //admin dashboard 
    {   
        //count total records of users, courses, modules, lectures
        $totalUsers = User::count(); 
        $totalCourses = Course::count();
        $totalModules = Module::count();
        $totalLectures = Lecture::count();

        //get latest announcements
        $announcements = Announcements::orderBy('created_at', 'desc')
                        ->take(4) //4 announcements
                        ->get();

        //get most taken courses
        $courseStats = DB::table('enrolmentcoursemodules')
            ->join('course', 'enrolmentcoursemodules.courseID', '=', 'course.courseID')
            ->select('course.courseName', DB::raw('COUNT(DISTINCT enrolmentcoursemodules.userID) as total'))
            ->groupBy('course.courseName')
            ->orderByDesc('total')
            ->take(5) //5 courses
            ->get();

                                                            /* summary of resources */

        //get recent uploaded material
        $recentMaterial = DB::table('learningmaterials')
            ->orderByDesc('created_at')
            ->first();

        //get latest uploaded PDF
        $recentPdf = DB::table('pdflearning')
            ->join('learningmaterials','pdflearning.learningMaterialID','=','learningmaterials.learningMaterialID')
            ->select('learningmaterials.learningMaterialTitle')
            ->orderByDesc('learningmaterials.created_at')
            ->first();

        //get latest uploaded video learning
        $recentVideo = DB::table('videolearning')
            ->join('learningmaterials','videolearning.learningMaterialID','=','learningmaterials.learningMaterialID')
            ->select('learningmaterials.learningMaterialTitle')
            ->orderByDesc('learningmaterials.created_at')
            ->first();

        //count no lecture assigned
        $unusedMaterials = DB::table('learningmaterials')
            ->whereNull('lectID')
            ->count();

                                                                                        /* pie chart */

        //count completed modules
        $completedModules = DB::table('enrolmentcoursemodules')
            ->where('isCompleted', 1)
            ->count();

        //count resources
        // total pdf learning materials
        $pdfMaterials = DB::table('pdflearning')->count();
        // total video learning materials
        $videoMaterials = DB::table('videolearning')->count();

        //notifications of forgot requests password, feedback, announcement
        $forgotRequests = DB::table('user')
            ->where('reset_request', 1)
            ->count();
        $feedbackCount = DB::table('coursefeedback')->count();
        $announcementReview = DB::table('announcements')
            ->where('status', 'pending')
            ->count();

        //total notifications
        $totalNotifications = $forgotRequests + $feedbackCount + $announcementReview;

        return view('admin.admin_dashboard', compact( //send data back to dashboard
            'totalUsers',
            'totalCourses',
            'totalModules',
            'totalLectures',
            'announcements',
            'courseStats',
            'completedModules',
            'pdfMaterials',
            'videoMaterials',
            'recentMaterial',
            'recentPdf',
            'recentVideo',
            'unusedMaterials',
            'forgotRequests',
            'feedbackCount',
            'announcementReview',
            'totalNotifications'
        ));
    }

    public function userManagement(Request $request)
    {
        $search = $request->search;

        // summary cards
        $totalUsers = DB::table('user')->count();
        $newUsers = DB::table('user')
            ->whereDate('userID', '>=', now()->subDays(7)) // placeholder if no created_at
            ->count();
        $activeUsers = DB::table('enrolmentcoursemodules')
            ->where('inProgress', 1)
            ->distinct('userID')
            ->count('userID');
        // user table
        $users = DB::table('user')
            ->leftJoin('enrolmentcoursemodules', 'user.userID', '=', 'enrolmentcoursemodules.userID')
            ->when($search, function ($query, $search) {
                return $query->where('user.userName', 'like', "%$search%");
            })
            ->select(
                'user.userID',
                'user.userName as name',
                'user.userEmail as email',
                DB::raw('COUNT(CASE WHEN enrolmentcoursemodules.inProgress = 1 THEN 1 END) as engagement'),
                DB::raw('COUNT(CASE WHEN enrolmentcoursemodules.isCompleted = 1 THEN 1 END) as completedCourses')
            )
            ->groupBy('user.userID', 'user.userName', 'user.userEmail')
            ->get();

        return view('admin.user_management', compact(
            'users',
            'totalUsers',
            'newUsers',
            'activeUsers'
        ));
    }

    public function courseModuleManagement()
    {
        $courses = Course::with('modules.lectures.sections')->get();
        $totalUsers = User::count();
        $totalCourses = Course::count();
        $totalModules = Module::count();
        $totalLectures = Lecture::count();
        $totalFeedback = Feedback::count();
        $totalAssessmentsPassed = AssessmentResult::where('status', 'passed')->count();
        $totalCompleted = Progress::where('progressStatus', 'completed')->count();

        $topUser = User::withSum('assessmentResults', 'score')
            ->orderByDesc('assessment_results_sum_score')
            ->first();

        $announcements = Announcements::orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        return view('admin.course_module_management', compact(
            'courses',
            'totalUsers',
            'totalCourses',
            'totalModules',
            'totalLectures',
            'totalFeedback',
            'totalAssessmentsPassed',
            'totalCompleted',
            'topUser',
            'announcements'
        ));
    }

    public function createCourseModule()
    {
        $courses = Course::all();
        $modules = Module::with('course')->get();
        $lectures = Lecture::with('module')->get();
        $sections = LectureSection::with('lecture')->orderBy('section_order')->get();

        return view('admin.add_course_module', compact(
            'courses',
            'modules',
            'lectures',
            'sections'
        ));
    }

    public function storeCourse(Request $request)
    {
        $request->validate([ //validate form input
            'courseCode' => 'required',
            'courseName' => 'required',
            'courseAuthor' => 'required',
            'courseLevel' => 'required'
        ]);

        $course = new Course(); //create new course

        //assign values 
        $course->courseCode = $request->courseCode;
        $course->courseName = $request->courseName;
        $course->courseAuthor = $request->courseAuthor;
        $course->courseDesc = $request->courseDesc;
        $course->courseCategory = $request->courseCategory;
        $course->courseLevel = $request->courseLevel;
        $course->courseDuration = $request->courseDuration;
        $course->isAvailable = $request->isAvailable;
        //handle image upload
        if ($request->hasFile('courseImg')) {
            // delete old image if exists
            if (!empty($course->courseImg) && file_exists(public_path($course->courseImg))) {
                unlink(public_path($course->courseImg));
            }
            // generate filename
            $filename = time() . '.' . $request->file('courseImg')->extension();
            // move file to public/courses
            $request->file('courseImg')->move(public_path('courses'), $filename);
            // save path in DB
            $course->courseImg = 'courses/' . $filename;
        }
        $course->save(); //save to db

        return redirect()->route('admin.course.module')->with('success', 'Course added successfully!');
    }

    public function updateCourse(Request $request, $id)
    { //when user click on edit button of the course
        $course = Course::findOrFail($id);
        $course->courseCode = $request->courseCode;
        $course->courseName = $request->courseName;
        $course->courseAuthor = $request->courseAuthor;
        $course->courseDesc = $request->courseDesc;
        $course->courseCategory = $request->courseCategory;
        $course->courseLevel = $request->courseLevel;
        $course->courseDuration = $request->courseDuration;
        $course->isAvailable = $request->isAvailable;
        //update image
        if ($request->hasFile('courseImg')) {
            // delete old image
            if (!empty($course->courseImg) && file_exists(public_path($course->courseImg))) {
                unlink(public_path($course->courseImg));
            }
            // generate filename
            $filename = time() . '.' . $request->file('courseImg')->extension();
            // move file to public/courses
            $request->file('courseImg')->move(public_path('courses'), $filename);
            // save path in DB
            $course->courseImg = 'courses/' . $filename;
        }
        $course->save();

        return redirect()->route('admin.course.module')
            ->with('success','Course updated successfully');
    } 
    
    public function editCourse($id)
    {
        $course = Course::findOrFail($id);
        return view('admin.edit_course_module', compact('course'));
    }

    public function deleteCourse($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->route('admin.course.module')
            ->with('success','Course deleted successfully');
    }

    public function editSection($id)
    {
        $section = LectureSection::findOrFail($id);

        return view('admin.edit_section', compact('section'));
    }

    public function updateSection(Request $request, $id)
    {
        $request->validate([
            'section_title' => 'required',
            'section_content' => 'required',
            'section_type' => 'required'
        ]);

        $section = LectureSection::findOrFail($id);

        $section->section_title = $request->section_title;
        $section->section_content = $request->section_content;
        $section->section_type = $request->section_type;

        $section->save();

        return back()->with('success', 'Section updated successfully');
    }

    public function deleteSection($id)
    {
        $section = LectureSection::findOrFail($id);
        $section->delete();

        return back()->with('success','Section deleted successfully');
    }
    public function storeMaterials(Request $request, $id) //store learning materials
    {   //loop every each of uploaded material
        foreach ($request->materials as $material) {
            $data = [
                'section_id' => $id,
                'type' => $material['type'],
            ];
            //check if any pdf upload
            if ($material['type'] == 'pdf' && isset($material['file'])) {
                $file = $material['file'];
                $path = $file->store('materials', 'public'); //store file in storage/public/materials
                $data['content'] = $path;
            } else { //or else store text or link
                $data['content'] = $material['content'] ?? null;
            }
            LearningMaterials::create($data); //insert into db
        }
        return back()->with('success', 'Materials added successfully!');
    }
    public function progress() //user progress status
    {
        $totalProgress = Progress::count(); 
        //count statuses
        $notStarted = Progress::where('progressStatus', 'Not Started')->count();
        $inProgress = Progress::where('progressStatus', 'In Progress')->count();
        $completed = Progress::where('progressStatus', 'Completed')->count();
        //convert to percentage
        $notStartedPercent = $totalProgress > 0 ? round(($notStarted / $totalProgress) * 100) : 0;
        $inProgressPercent = $totalProgress > 0 ? round(($inProgress / $totalProgress) * 100) : 0;
        $completedPercent = $totalProgress > 0 ? round(($completed / $totalProgress) * 100) : 0;

        return view('admin.progress', compact(
            'notStartedPercent',
            'inProgressPercent',
            'completedPercent'
        ));
    }

    public function announcements()
    {
        //newest announcements always appear first
        $announcements = DB::table('announcements')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.announcements', compact('announcements')); //retrieve
    }

    public function createAnnouncement()
    {
        return view('admin.create_announcement');
    }

    public function storeAnnouncement(Request $request)
    {
        DB::table('announcements')->insert([
            'announcementTitle' => $request->announcementTitle,
            'announcementDetails' => $request->announcementDetails,
            'adminID' => Auth::id(),   // get logged in admin ID
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('admin.announcements')
            ->with('success', 'Announcement added successfully!');
    }

    public function viewAnnouncement($id)
    {
        $announcement = Announcements::where('announcementID', $id)->first();
        return view('admin.viewAnnouncement', compact('announcement'));
    }

    public function reviewAnnouncement($id)
    {
        $announcement = Announcements::where('announcementID', $id)->first();
        return view('admin.reviewAnnouncement', compact('announcement'));
    }

    public function editAnnouncement($id)
    {
        $announcement = Announcements::where('announcementID', $id)->first();
        return view('admin.editAnnouncement', compact('announcement'));
    }

    public function updateAnnouncement(Request $request, $id)
    {
        $announcement = Announcements::findOrFail($id);

        $announcement->announcementTitle = $request->announcementTitle;
        $announcement->announcementDetails = $request->announcementDetails;

        $announcement->save();

        return redirect()->route('announcements')
            ->with('success', 'Announcement updated successfully.');
    }
    
    public function reports()
    {

        // total registered users
        $totalUsers = DB::table('user')->count();

        // new users per month
        $newUsers = DB::table('user')
            ->whereMonth('created_at', now()->month)
            ->count();

        // active users (authenticated = 1)
        $activeUsers = DB::table('user')
            ->where('authenticated', 1)
            ->count();

        // inactive users
        $inactiveUsers = DB::table('user')
            ->where('authenticated', 0)
            ->count();

        // guest users by session
        $guestUsers = 0;

        // course & module
        $courseModules = DB::table('course')
            ->join('module', 'course.courseID', '=', 'module.courseID')
            ->select(
                'course.courseName',
                'module.moduleName',
                DB::raw('COUNT(enrolmentcoursemodules.userID) as enrolled'),
                DB::raw('SUM(enrolmentcoursemodules.isCompleted) as completed'),
                DB::raw('SUM(enrolmentcoursemodules.inProgress) as in_progress')
            )
            ->leftJoin('enrolmentcoursemodules', 'module.moduleID', '=', 'enrolmentcoursemodules.moduleID')
            ->groupBy('course.courseName','module.moduleName')
            ->get();

        return view('admin.reports', compact(
            'totalUsers',
            'newUsers',
            'activeUsers',
            'inactiveUsers',
            'guestUsers',
            'courseModules'
        ));
    }

    public function reportOverview()
    {
        // total users
        $totalUsers = User::count();

        // new users registered in a month
        $newUsers = User::whereMonth('created_at', now()->month)->count();

        // active users that logged in
        $activeUsers = User::where('status', 'active')->count();

        // inactive users
        $inactiveUsers = User::where('status', 'inactive')->count();

        // guest or unregistered users
        $guestUsers = 0;

        // course and module performance
        $courseModules = DB::table('course')
            ->join('module', 'course.courseID', '=', 'module.courseID')
            ->select(
                'course.courseName',
                'module.moduleName',
                DB::raw('0 as enrolled'),
                DB::raw('0 as completed'),
                DB::raw('0 as in_progress')
            )
            ->get();

        return view('admin.reportOverview', compact(
            'totalUsers',
            'newUsers',
            'activeUsers',
            'inactiveUsers',
            'guestUsers',
            'courseModules'
        ));
    }

    public function downloadReport() //download report in pdf
    {   
        //collect statistics
        $totalUsers = DB::table('user')->count(); 
        // new user recent register
        $newUsers = DB::table('user')
            ->whereDate('created_at', today())
            ->count();
        // active user define by authenticated attribute
        $activeUsers = DB::table('user')
            ->where('authenticated', 1)
            ->count();

        // inactive users define by authenticated attribute
        $inactiveUsers = DB::table('user')
            ->where('authenticated', 0)
            ->count();

        // guest users store by session
        $guestUsers = 0;

        // course and module
        $courseModules = DB::table('module')
            ->join('course','module.courseID','=','course.courseID')
            ->leftJoin('enrolmentcoursemodules','module.moduleID','=','enrolmentcoursemodules.moduleID')
            ->select(
                'course.courseName',
                'module.moduleName',

                DB::raw('COUNT(enrolmentcoursemodules.userID) as enrolled'),

                DB::raw('SUM(enrolmentcoursemodules.isCompleted = 1) as completed'),

                DB::raw('SUM(enrolmentcoursemodules.inProgress = 1) as in_progress')
            )
            ->groupBy('module.moduleID','course.courseName','module.moduleName')
            ->get();

        $assessmentReport = DB::table('mcqs')
            ->join('module','mcqs.moduleID','=','module.moduleID')
            ->select(
                'module.moduleName',
                DB::raw('COUNT(mcqs.moduleQs_ID) as totalAssessment')
            )
            ->groupBy('module.moduleName')
            ->get();

        $data = compact(
            'totalUsers',
            'newUsers',
            'activeUsers',
            'inactiveUsers',
            'guestUsers',
            'courseModules',
            'assessmentReport'
        );
        $pdf = Pdf::loadView('admin.reportPDF',$data); //load view into pdf
        return $pdf->download('bengoh-dam_report.pdf'); //name of downloaded report pdf
    }

    public function passwordRequests()
    {
        $requests = DB::table('users')
            ->where('forgot_password', 1)
            ->get();

        return view('admin.passwordRequests', compact('requests'));
    }

    public function settings()
    {
        return view('admin.admin_settings');
    }

    public function feedback()
    {
        $feedbacks = DB::table('coursefeedback')->get();

        return view('admin.feedback', compact('feedbacks'));
    }

    public function helpSupport()
    {
        return view('admin.admin_help_support');
    }
}
