<?php

//handles admin panel logic
namespace App\Http\Controllers;

//import models
use App\Models\LearningMaterials;
use App\Models\Users;
use App\Models\Course;
use App\Models\Module;
use App\Models\Lecture;
use App\Models\LectureSection;
use App\Models\Progress;
use App\Models\Announcements;
use App\Models\Feedback;
use App\Models\AssessmentResult;
use App\Models\Mcqs;

//laravel utilities
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

//pdf generator
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function dashboard() //admin dashboard 
    {   
        //count total records of users, courses, modules, lectures
        $totalUsers = Users::count(); 
        $totalCourses = Course::count();
        $totalModules = Module::count();
        $totalLectures = Lecture::count();

        //get latest announcements, 4 announcements
        $announcements = Announcements::orderBy('created_at', 'desc')->take(4)->get();

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
        $recentMaterial = DB::table('learningmaterials')->orderByDesc('created_at')->first();

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
        $unusedMaterials = DB::table('learningmaterials')->whereNull('lectID')->count();
                                                                                        /* pie chart */

        //count completed modules
        $completedModules = DB::table('enrolmentcoursemodules')->where('isCompleted', 1)->count();

        //count resources
        // total pdf learning materials
        $pdfMaterials = DB::table('pdflearning')->count();

        // total video learning materials
        $videoMaterials = DB::table('videolearning')->count();

        //notifications of forgot requests password, feedback, announcement
        $forgotRequests = DB::table('users')->where('must_change_password', 1)->count();
        $pendingFeedbackCount = DB::table('coursefeedback')->where('is_reviewed', 0)->count();
        $announcementReview = DB::table('announcements')->where('status', 'pending')->count();

        //total notifications
        $totalNotifications = $forgotRequests + $pendingFeedbackCount + $announcementReview;

        return view('admin.admin_dashboard', compact( //send data back to dashboard
            'totalUsers','totalCourses','totalModules','totalLectures','announcements','courseStats','completedModules','pdfMaterials','videoMaterials',
            'recentMaterial','recentPdf','recentVideo','unusedMaterials','forgotRequests','pendingFeedbackCount','announcementReview','totalNotifications'
        ));
    }

    public function userManagement(Request $request)
    {
        $search = $request->search;

        // summary cards
        $totalUsers = DB::table('users')->count();
        $newUsers = DB::table('users')->whereDate('created_at', '>=', now()->subDays(7))->count();
        $activeUsers = DB::table('enrolmentcoursemodules')->where('inProgress', 1)->distinct('userID')->count('userID');

        // user table
        $users = DB::table('users')
            ->leftJoin('enrolmentcoursemodules', 'users.userID', '=', 'enrolmentcoursemodules.userID')
            ->when($search, function ($query, $search) {
                return $query->where('users.userName', 'like', "%$search%");
            })
            ->select(
                'users.userID', 'users.userName as name', 'users.userEmail as email',
                DB::raw('COUNT(CASE WHEN enrolmentcoursemodules.inProgress = 1 THEN 1 END) as engagement'),
                DB::raw('COUNT(CASE WHEN enrolmentcoursemodules.isCompleted = 1 THEN 1 END) as completedCourses')
            )
            ->groupBy('users.userID', 'users.userName', 'users.userEmail')->get();

        // search engine function
        $error = null;
        if ($search && $users->isEmpty()) {
            $error = 'User does not exist.';
        }

        // notifications count
        $forgotRequests = DB::table('users')->where('must_change_password', 1)->count();
        $pendingFeedbackCount = DB::table('coursefeedback')->where('is_reviewed', 0)->count();
        $announcementReview = DB::table('announcements')->where('status', 'pending')->count();
        $totalNotifications = $forgotRequests + $pendingFeedbackCount + $announcementReview;

        return view('admin.user_management', compact(
            'users','totalUsers','newUsers','activeUsers','totalNotifications','pendingFeedbackCount','forgotRequests','announcementReview','error'
        ));
    }

    public function deleteUser($id)
    {
        $user = DB::table('users')->where('userID', $id)->first();
        if (!$user) {return redirect()->back()->with('error', 'User does not exist.');}
         DB::table('users')->where('userID', $id)->delete();
        return redirect()->back()->with('success', 'User deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('user_ids');
        if (!$ids || count($ids) === 0) {
            return redirect()->back()->with('error', 'Please select at least one user to remove.');
        }
        \App\Models\Users::whereIn('userID', $ids)->delete();
        return redirect()->back()->with('success', 'Selected users have been removed.');
    }

    public function courseModuleManagement()
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

        return view('admin.course_module_management', compact(
            'courses','totalUsers','totalCourses','totalModules','totalLectures','totalFeedback','totalAssessmentsPassed',
            'totalCompleted','topUser','announcements'
        ));
    }

    public function createCourseModule()
    {
        $courses = Course::all();
        $modules = Module::with(['course','mcqs'])->get();
        $lectures = Lecture::with('module')->get();
        $sections = LectureSection::with('lecture')->orderBy('section_order')->get();

        return view('admin.add_course_module', compact('courses','modules','lectures','sections'));
    }

    public function storeCourse(Request $request)
    {
        //validate form input
        $request->validate([ 'courseCode' => 'required','courseName' => 'required','courseAuthor' => 'required','courseLevel' => 'required']);
        $course = new Course(); //create new course
        //assign values 
        $course->courseCode = $request->courseCode;
        $course->courseName = $request->courseName;
        $course->courseAuthor = $request->courseAuthor;
        $course->courseDesc = $request->courseDesc;
        $course->courseCategory = $request->courseCategory;
        $course->courseLevel = $request->courseLevel;
        $course->courseDuration = $request->courseDuration;
        $course->isAvailable = $request->input('isAvailable', 0); //available is 1, not available is 0
        //handle image upload
        if ($request->hasFile('courseImg')) {
            // Force Laravel to use the 'r2' disk specifically
            $path = $request->file('courseImg')->store('courses-assets', 'r2');
            $course->courseImg = $path;
        }
        $course->save();
        
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
            // Force Laravel to use the 'r2' disk specifically
            $path = $request->file('courseImg')->store('courses-assets', 'r2');
            $course->courseImg = $path;
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

        // delete related records first
        $course->enrolments()->delete();

        // optionally delete other relations too
        $course->modules()->delete();
        $course->feedback()->delete();

        // now delete course
        $course->delete();

        return redirect()->route('admin.course.module')
            ->with('success', 'Course deleted successfully');
    }

    private function mockAI($content, $count = 3)
    {
        $questions = [];
        for ($i = 1; $i <= $count; $i++) {
            $answers = ["Correct Answer $i","Wrong Answer A$i","Wrong Answer B$i","Wrong Answer C$i"];
            $questions[] = ['question' => "AI Question $i based on: " . substr($content, 0, 50),'answers' => $answers,'correct' => 0];
        }
        return $questions;
    }

    private function generateWithAI($content, $count = 3)
    {
        $response = Http::withHeaders(['Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),'Content-Type' => 'application/json',])
        ->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4o-mini','messages' => [
                ['role' => 'system','content' => 'You generate multiple choice questions.'],
                ['role' => 'user','content' => "Generate {$count} MCQ questions based on this content.
                    Return ONLY JSON like:
                    [{
                        \"question\": \"...\",
                        \"answers\": [\"...\",\"...\",\"...\",\"...\"],
                        \"correct\": 0
                    }]
                    Content:" . substr($content, 0, 1500)]],'temperature' => 0.7,]);
        $data = $response->json();
        $aiText = $data['choices'][0]['message']['content'] ?? '';
        $aiText = str_replace(['```json', '```'], '', $aiText);
        $aiText = trim($aiText);
        $questions = json_decode($aiText, true);
        if (!$questions) {
            throw new \Exception("Invalid AI response: " . $aiText);
        }
        return $questions;
    }

    public function generateAI(Request $request, $moduleID)
    {
        $count = min((int) $request->input('count', 3), 20); //min 3, max 20
        try {
            $lectures = Lecture::where('moduleID', $moduleID)->pluck('lectID');
            $contents = LectureSection::whereIn('lectID', $lectures)->pluck('section_content')->implode("\n");
            if (!$contents) {
                return response()->json(['error' => 'No content found'], 400);
            }
            $questions = $this->generateWithAI($contents, $count);
            //get existing MCQs for this module
            $existingMcqs = Mcqs::where('moduleID', $moduleID)
                ->orderBy('moduleQs_ID')->get()->values();

            foreach ($existingMcqs as $index => $mcq) {
                if (isset($questions[$index])) {$q = $questions[$index];
                    Mcqs::create([
                        'moduleID' => $moduleID,
                        'moduleQs' => $mcq->moduleQs, // keep manual as history
                        'question' => $q['question'], // AI version
                        'answer1' => $q['answers'][0],
                        'answer2' => $q['answers'][1],
                        'answer3' => $q['answers'][2],
                        'answer4' => $q['answers'][3],
                        'correct_answer' => $q['correct'],
                        'group_id' => $mcq->group_id, // SAME group
                        'source' => 'ai',
                        'is_active' => 0
                    ]);
                }
            }

            //handle extra AI questions (if AI returns more than existing rows)
            if (count($questions) > $existingMcqs->count()) {
                for ($i = $existingMcqs->count(); $i < count($questions); $i++) {
                    $q = $questions[$i];
                    Mcqs::create([
                        'moduleID' => $moduleID, 'moduleQs' => $q['question'], 'question' 
                        => $q['question'],'answer1' => $q['answers'][0],'answer2' => $q['answers'][1],
                            'answer3' => $q['answers'][2],'answer4' => $q['answers'][3],'correct_answer' => $q['correct'],
                    ]);
                }
            }
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function useAiQuestion($id)
    {
        $selected = Mcqs::findOrFail($id);

        //deactivate all in the same group
        Mcqs::where('group_id', $selected->group_id)
            ->update(['is_active' => 0]);

        //activate selected one
        $selected->update([
            'is_active' => 1
        ]);

        return back()->with('success', 'AI question is now active');
    }

    public function mcqResults()
    {
        // Fetching results where type is 'mcq'
        // Assuming AssessmentResult model relates to Users and Course/Module
        $results = AssessmentResult::where('type', 'mcq')
            ->with(['user']) // Eager load the user details
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.mcq_results', compact('results'));
    }

    public function assessmentResults()
    {
        // Fetching results where type is 'final'
        $results = AssessmentResult::where('type', 'final')
            ->with(['user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.assessment_results', compact('results'));
    }

    public function courseResults($id)
    {
        // 1. Get the course details
        $course = Course::findOrFail($id);
        
        // 2. Query AssessmentResult for this specific course
        // We use with('user') so we can show the learner's name
        $results = AssessmentResult::where('courseID', $id)
            ->with(['user']) 
            ->orderBy('created_at', 'desc')
            ->get();

        // 3. Return the view with the data
        return view('admin.course_results', compact('course', 'results'));
    }
    
    public function storeMaterials(Request $request, $id)
    {
        //added a check to prevent errors if no materials are added
        if (!$request->has('materials')) {
            return back()->with('error', 'No materials to save.');
        }
        foreach ($request->materials as $material) {
            $data = [
                'sectionID' => $id,
                'type'      => $material['type'],
            ];
            if ($material['type'] == 'pdf' && isset($material['file'])) {
                $file = $material['file'];
                $path = $file->store('materials', 'public');
                $data['content'] = $path;
            } else {
                $data['content'] = $material['content'] ?? null;
            }
            LearningMaterials::create($data);
        }
        return back()->with('success', 'Materials added successfully!');
    }

    public function progress()
    {
        //course progress
        $totalProgress = Progress::count();
        $notStarted = Progress::where('progressStatus', 'Not Started')->count();
        $inProgress = Progress::where('progressStatus', 'In Progress')->count();
        $completed = Progress::where('progressStatus', 'completed')->count();
        $notStartedPercent = $totalProgress ? round(($notStarted / $totalProgress) * 100) : 0;
        $inProgressPercent = $totalProgress ? round(($inProgress / $totalProgress) * 100) : 0;
        $completedPercent = $totalProgress ? round(($completed / $totalProgress) * 100) : 0;
        //mcqs progress
        $totalMcq = AssessmentResult::where('type', 'mcq')->count();
        $mcqAttemptedCount = AssessmentResult::where('type', 'mcq')->where('attempts', '>', 0)->count();
        $mcqNotAttemptedCount = AssessmentResult::where('type', 'mcq')->where('attempts', 0)->count();
        $mcqAttempted = $totalMcq ? round(($mcqAttemptedCount / $totalMcq) * 100) : 0;
        $mcqNotAttempted = $totalMcq ? round(($mcqNotAttemptedCount / $totalMcq) * 100) : 0;
        $mcqAssigned = 100;
        //course assessment
        $totalAssessments = AssessmentResult::where('type', 'final')->count();
        $assessmentCompletedCount = AssessmentResult::where('type', 'final')->where('status', 'pass')->count();
        $assessmentPendingCount = AssessmentResult::where('type', 'final')->where('status', '!=', 'pass')->count();
        $assessmentCompleted = $totalAssessments ? round(($assessmentCompletedCount / $totalAssessments) * 100) : 0;
        $assessmentPending = $totalAssessments ? round(($assessmentPendingCount / $totalAssessments) * 100) : 0;
        $assessmentNotStarted = 0;
        //average score
        $averageScore = round(AssessmentResult::avg('score') ?? 0);
        return view('admin.progress', compact(
            'notStartedPercent',
            'inProgressPercent',
            'completedPercent',
            'mcqAttempted',
            'mcqNotAttempted',
            'mcqAssigned',
            'assessmentCompleted',
            'assessmentPending',
            'assessmentNotStarted',
            'averageScore'
        ));
    }
    
    public function announcements()
    {
        //newest announcements always appear first
        $announcements = DB::table('announcements')->orderByDesc('created_at')->get();
        return view('admin.announcements', compact('announcements')); //retrieve
    }

    public function createAnnouncement(){return view('admin.create_announcement'); }        

    public function storeAnnouncement(Request $request)
    {
        DB::table('announcements')->insert([
            'announcementTitle' => $request->announcementTitle,
            'announcementDetails' => $request->announcementDetails,
            'adminID' => Auth::id(),
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
        $courseModules = DB::table('course')->join('module', 'course.courseID', '=', 'module.courseID')
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

        return view('admin.reports', compact('totalUsers','newUsers','activeUsers','inactiveUsers','guestUsers','courseModules'
        ));
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
        $courseModules = DB::table('course')->join('module', 'course.courseID', '=', 'module.courseID')
            ->select('course.courseName','module.moduleName',DB::raw('0 as enrolled'),DB::raw('0 as completed'),DB::raw('0 as in_progress'))
            ->get();

        return view('admin.reportOverview', compact('totalUsers','newUsers','activeUsers','inactiveUsers','guestUsers','courseModules'));
    }

    public function downloadReport() //download report in pdf
    {   
        //collect statistics
        $totalUsers = DB::table('users')->count(); 
        // new user recent register
        $newUsers = DB::table('users')->whereDate('created_at', today())->count();
        // active user define by authenticated attribute
        $activeUsers = DB::table('users')->where('authenticated', 1)->count();
        // inactive users define by authenticated attribute
        $inactiveUsers = DB::table('users')->where('authenticated', 0)->count();
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
            ->select('module.moduleName',DB::raw('COUNT(mcqs.moduleQs_ID) as totalAssessment'))
            ->groupBy('module.moduleName')
            ->get();

        $data = compact('totalUsers','newUsers','activeUsers','inactiveUsers','guestUsers','courseModules','assessmentReport');
        
        $pdf = Pdf::loadView('admin.reportPDF',$data); //load view into pdf
        return $pdf->download('bengoh-dam_report.pdf'); //name of downloaded report pdf
    }

    public function passwordRequests()
    {
        $requests = DB::table('users')->where('reset_request', 1)->get();
        return view('admin.passwordRequests', compact('requests'));
    }

    public function settings(){return view('admin.admin_settings');}

    public function feedbackList()
    {
        //mark all unread feedback as reviewed
        Feedback::where('is_reviewed', false)->update(['is_reviewed' => true]);
        //fetch data
        $feedbacks = Feedback::with(['user', 'course'])->get();
        return view('admin.feedback', compact('feedbacks'));
    }

    public function helpSupport(){return view('admin.admin_help_support');}
}
