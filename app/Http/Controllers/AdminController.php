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
use App\Models\LectureSection;
use App\Models\AssessmentResult;

//laravel utilities
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class AdminController extends Controller
{
        public function index() //admin dashboard
        {
            //card status
            $stats = [
                'totalUsers'    => Users::count(),
                'totalCourses'  => Course::count(),
                'totalModules'  => Module::count(),
                'totalLectures' => Lecture::count(),
            ];

            $announcements = Announcements::latest()->take(4)->get();
            $courseStats = DB::table('enrolmentcoursemodules')
                ->join('course', 'enrolmentcoursemodules.courseID', '=', 'course.courseID')
                ->select('course.courseName', DB::raw('COUNT(DISTINCT enrolmentcoursemodules.userID) as total'))
                ->groupBy('course.courseName')
                ->orderByDesc('total')
                ->take(5)
                ->get();
            $recentMaterial = DB::table('learningmaterials')->latest()->first();
            //avoid repeating join logic for PDFs and Videos
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
            //data for charts & notifications
            $chartData = [
                'completedModules' => DB::table('enrolmentcoursemodules')->where('isCompleted', 1)->count(),
                'pdfMaterials'     => DB::table('pdflearning')->count(),
                'videoMaterials'   => DB::table('videolearning')->count(),
            ];
            /* add into AppServiceProvider.php to calculate 
            $notifications = [
                'forgotRequests'     => Users::where('reset_request', 1)->count(),
                'feedbackCount'      => DB::table('coursefeedback')->count(),
                'announcementReview' => Announcements::where('status', 'pending')->count(),
            $totalNotifications = array_sum($notifications); ];*/

            //merge all variables into the view
            return view('admin.admin_dashboard', array_merge(
                $stats, 
                $chartData, 
                //$notifications, 
                compact('announcements', 'courseStats', 'recentMaterial', 'recentPdf', 'recentVideo', 'unusedMaterials')//, 'totalNotifications'
            ));
        }

        public function userManagement(Request $request) //user management in admin
        {
            $search = $request->search;
            // summary cards
            $totalUsers = DB::table('users')->count();
            $newUsers = DB::table('users')
                ->whereDate('userID', '>=', now()->subDays(7)) // placeholder if no created_at
                ->count();
            $activeUsers = DB::table('enrolmentcoursemodules')
                ->where('inProgress', 1)
                ->distinct('userID')
                ->count('userID');
            // user table
            $users = DB::table('users')
                ->leftJoin('enrolmentcoursemodules', 'users.userID', '=', 'enrolmentcoursemodules.userID')
                ->when($search, function ($query, $search) {
                    return $query->where('users.userName', 'like', "%$search%");
                })
                ->select(
                    'users.userID',
                    'users.userName as name',
                    'users.userEmail as email',
                    DB::raw('COUNT(CASE WHEN enrolmentcoursemodules.inProgress = 1 THEN 1 END) as engagement'),
                    DB::raw('COUNT(CASE WHEN enrolmentcoursemodules.isCompleted = 1 THEN 1 END) as completedCourses')
                )
                ->groupBy('users.userID', 'users.userName', 'users.userEmail')
                ->get();

            return view('admin.user_management', compact('users','totalUsers','newUsers','activeUsers'));
        }


        public function courseManagement() //manage course and module section
        {
            $courses = Course::with('modules.lectures.sections')->get();
            $totalUsers = Users::count();
            $totalCourses = Course::count();
            $totalModules = Module::count();
            $totalLectures = Lecture::count();
            $totalFeedback = Feedback::count();
            $totalAssessmentsPassed = AssessmentResult::where('status', 'passed')->count();
            $totalCompleted = Progress::where('progressStatus', 'completed')->count();
            $topUser = Users::withSum('assessmentResults', 'score')->orderByDesc('assessment_results_sum_score')->first();
            $announcements = Announcements::orderBy('created_at', 'desc')->take(4)->get();
            //sends all data to course_module_management view
            return view('admin.course_module_management', compact(
                'courses','totalUsers','totalCourses','totalModules','totalLectures','totalFeedback','totalAssessmentsPassed','totalCompleted','topUser','announcements'));
        }

        //fetches and sends data to views to allow admin create or manage course content
        public function createCourse() //renamed from createCourseModule
        {
            $courses = Course::all(); //get all courses from db
            $modules = Module::with('course')->get(); //get all modules, incl related course respectively
            $lectures = Lecture::with('module')->get(); //get all lectures, incl related module respectively
            $sections = LectureSection::with('lecture')->orderBy('section_order')->get(); //get all lecture setions then sort 
            return view('admin.add_course_module', compact('courses','modules','lectures','sections')); //sends all data to add_course_module view
        }

        //handles new course form and save
        public function storeCourse(Request $request)
        {   //validate form input
            $request->validate(['courseCode' => 'required','courseName' => 'required','courseAuthor' => 'required','courseLevel' => 'required']);
            $course = new Course(); //create new object
            //assign values
            $course->courseCode = $request->courseCode;
            $course->courseName = $request->courseName;
            $course->courseAuthor = $request->courseAuthor;
            $course->courseDesc = $request->courseDesc;
            $course->courseCategory = $request->courseCategory;
            $course->courseLevel = $request->courseLevel;
            $course->courseDuration = $request->courseDuration;
            $course->isAvailable = $request->isAvailable;
            //handle image upload in /public/courses
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
            return redirect()->route('admin.course.module')->with('success', 'Course added successfully!'); //sends the user back
        }

        //update existing course's details
        public function updateExistedCourse(Request $request, $id)
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
            //update image from /public/courses
            if ($request->hasFile('courseImg')) {
                // delete old image from /public/courses
                if (!empty($course->courseImg) && file_exists(public_path($course->courseImg))) {
                    unlink(public_path($course->courseImg));
                }
                // generate filename
                $filename = time() . '.' . $request->file('courseImg')->extension();
                // move file to /public/courses
                $request->file('courseImg')->move(public_path('courses'), $filename);
                // save path in DB
                $course->courseImg = 'courses/' . $filename;
            }
            $course->save();
            return redirect()->route('admin.course.module')->with('success','Course updated successfully');
        }

        //edit selected course
        public function editCourse($id)
        {
            $course = Course::findOrFail($id);
            return view('admin.edit_course_module', compact('course'));
        }

        //delete selected course
        public function deleteCourse($id)
        {
            $course = Course::findOrFail($id);
            $course->delete();
            return redirect()->route('admin.course.module')->with('success','Course deleted successfully');
        }

        //retrieve selected lecture section data and display the form 
        public function editSection($id)
        {
            $section = LectureSection::findOrFail($id);
            return view('admin.edit_section', compact('section'));
        }

        //update existed section of lecture with new lecture data
        public function updateSection(Request $request, $id)
        {   //validation
            $request->validate(['section_title' => 'required','section_content' => 'required','section_type' => 'required']);
            $section = LectureSection::findOrFail($id); //find the section
            //update 
            $section->section_title = $request->section_title;
            $section->section_content = $request->section_content;
            $section->section_type = $request->section_type;
            //save update to db
            $section->save();
            return back()->with('success', 'Section updated successfully');
        }

        //deletes lecture section record from db
        public function deleteSection($id)
        {
            $section = LectureSection::findOrFail($id); //find the section
            $section->delete(); //delete the section
            return back()->with('success','Section deleted successfully');
        }
        
        //stores numbers of learning materials either PDFs, videos, texts, etc
        public function storeMaterials(Request $request, $id) //store learning materials
        {   //loop every each of uploaded material
            foreach ($request->materials as $material) {
                $data = ['section_id' => $id,'type' => $material['type'],];
                //check if any pdf upload
                if ($material['type'] == 'pdf' && isset($material['file'])) {
                    $file = $material['file'];
                    // generate filename
                    $filename = time() . '_' . $file->getClientOriginalName();
                    // move file to public/learningmaterials
                    $file->move(public_path('materials'), $filename);
                    // save path in DB
                    $data['content'] = 'learningmaterials/' . $filename; 
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

            return view('admin.progress', compact('notStartedPercent','inProgressPercent','completedPercent'));
        }

        public function announcements()
        {
            //newest announcements always appear first
            $announcements = DB::table('announcements') ->orderByDesc('created_at')->get();
            return view('admin.announcements', compact('announcements')); //retrieve
        }

        public function createAnnouncement(){return view('admin.create_announcement');}

        public function storeAnnouncement(Request $request)
        {
            DB::table('announcements')->insert([
                'announcementTitle' => $request->announcementTitle,
                'announcementDetails' => $request->announcementDetails,
                'adminID' => Auth::id(),   // get logged in admin ID
                'created_at' => now(),
                'updated_at' => now()
            ]);
            return redirect()->route('admin.announcements')->with('success', 'Announcement added successfully!');
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
            return redirect()->route('announcements')->with('success', 'Announcement updated successfully.');
                
        }
    
        public function reports()
        {
            // total registered users
            $totalUsers = DB::table('users')->count();
            // new users per month
            $newUsers = DB::table('users')->whereMonth('created_at', now()->month)->count();
            // active users (authenticated = 1)
            $activeUsers = DB::table('users')->where('authenticated', 1)->count();
            // inactive users
            $inactiveUsers = DB::table('users')->where('authenticated', 0)->count();
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
            return view('admin.reports', compact('totalUsers','newUsers','activeUsers','inactiveUsers','guestUsers','courseModules'));
        }


        public function reportOverview()
        {
            // total users
            $totalUsers = Users::count();
            // new users registered in a month
            $newUsers = Users::whereMonth('created_at', now()->month)->count();
            // active users that logged in
            $activeUsers = Users::where('status', 'active')->count();
            // inactive users
            $inactiveUsers = Users::where('status', 'inactive')->count();
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
            return view('admin.reportOverview', compact('totalUsers','newUsers','activeUsers','inactiveUsers','guestUsers','courseModules'));
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

            $data = compact('totalUsers','newUsers','activeUsers','inactiveUsers','guestUsers','courseModules','assessmentReport');
            $pdf = Pdf::loadView('admin.reportPDF',$data); //load view into pdf
            return $pdf->download('bengoh-dam_report.pdf'); //name of downloaded report pdf
        }

        public function passwordRequests()
        {
            $requests = DB::table('users')->where('forgot_password', 1)->get();
            return view('admin.passwordRequests', compact('requests'));}

        public function settings() {return view('admin.admin_settings');}

        public function feedback()
        {
            $feedbacks = DB::table('coursefeedback')->get();
            return view('admin.feedback', compact('feedbacks'));}
            
        public function helpSupport() {return view('admin.admin_help_support');}
}
