<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use App\Models\Progress;
use App\Models\LectureProgress;
use App\Models\Lecture;
use App\Models\Enrollment;
use App\Models\Users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;

class CourseController extends Controller
{
    // display all courses
    public function allCourses(Request $request)
    {
        $query = Course::where('isAvailable', 1);
        //search method
        if ($request->filled('search')) {
            $query->where('courseName', 'like', '%' . $request->search . '%');
        }

        //filter by category process
        if ($request->filled('category')) {
            $query->where('courseCategory', $request->category);
        }

        //filter by level process
        if ($request->filled('level')) {
            $query->where('courseLevel', $request->level);
        }

        //filter by duration process
        if ($request->filled('duration')) {
            $query->where('courseDuration', $request->duration);
        }

        //sorting
        switch ($request->sort) {
            case 'latest':
                $query->orderBy('created_at', 'desc');
                break;

            case 'updated':
                $query->orderBy('updated_at', 'desc');
                break;

            case 'short':
                $query->whereRaw('CAST(courseDuration AS UNSIGNED) <= 4');
                break;

            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        $perPage = $request->input('per_page', 3); // default to 3 if not selected
        $courses = $query->paginate($perPage)->withQueryString();
        //for dropdowns
        $categories = Course::where('isAvailable', 1)
            ->whereNotNull('courseCategory')
            ->select('courseCategory')
            ->distinct()
            ->orderBy('courseCategory')
            ->pluck('courseCategory');

        $levels = Course::where('isAvailable', 1)
            ->whereNotNull('courseLevel')
            ->select('courseLevel')
            ->distinct()
            ->orderBy('courseLevel')
            ->pluck('courseLevel');

        $durations = Course::where('isAvailable', 1)
            ->whereNotNull('courseDuration')
            ->select('courseDuration')
            ->distinct()
            ->orderBy('courseDuration')
            ->pluck('courseDuration');

        return view('learner.view_allCourse', compact('courses','categories','levels','durations'));
    }

    // show single course details
    public function showCourse($id)
    {
        $course = Course::with([
            'modules.lectures.materials.video',
            'modules.lectures.materials.pdf',
            'modules.enrolment',
            'modules.lectures',
            'modules.lectures.mcqs',
            'modules.lectures.mcqs.answers'
        ])->findOrFail($id);

        return view('learner.viewCourse', compact('course'));
    }
    
    //redirect user to start learning interface
    public function startLearning(Request $request, $id)
    {
        //get sectionId from query instead of route param
        $sectionId = $request->query('sectionId');

        if (Auth::check()) {
            $userId = Auth::id();
            $modules = DB::table('module')->where('courseID', $id)->get();

            foreach ($modules as $module) {
                $exists = DB::table('enrolmentcoursemodules')
                    ->where('userID', $userId)
                    ->where('moduleID', $module->moduleID)
                    ->exists();

                if (!$exists) {
                    DB::table('enrolmentcoursemodules')->insert([
                        'userID' => $userId,
                        'courseID' => $id,
                        'moduleID' => $module->moduleID,
                        'isCompleted' => 0,
                        'inProgress' => 1,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        }

        $course = Course::with(['modules.lectures.sections','modules.mcqs'])
            ->where('courseID', $id)
            ->firstOrFail();

        // collect all sections
        $sections = collect();
        foreach ($course->modules as $module) {
            foreach ($module->lectures as $lecture) {
                foreach ($lecture->sections as $section) {
                    $sections->push($section);
                }
            }
        }

        // sort sections
        $sections = $sections->sortBy('section_order')->values();

        $totalSections = $sections->count();

        if ($sections->isEmpty()) {
            return redirect()->route('courses.showCourse', $course->courseID)
                ->with('error', 'This module has no learning materials yet.');
        }

        $completedSections = 0;

        //current section logic
        if (!$sectionId) {
            // no sectionId → first section
            $currentIndex = 0;
            $current = $sections->first();
            $currentTranslation = $current->translations()
                ->where('locale', app()->getLocale())
                ->first();
        } else {
            // find section
            $currentIndex = $sections->search(
                fn($s) => (int)$s->sectionID === (int)$sectionId
            );

            // fallback if invalid
            if ($currentIndex === false) {
                $currentIndex = 0;
            }

            $current = $sections->get($currentIndex);
            $currentTranslation = $current->translations()
                ->where('locale', app()->getLocale())
                ->first();
        }

        $lecture = Lecture::find($current->lectID);

        // progress tracking
        if (Auth::check()) {
            Progress::updateOrCreate(
                [
                    'userID' => Auth::id(),
                    'courseID' => $id,
                    'progressName' => 'SECTION_' . $current->sectionID
                ],
                [
                    'progressStatus' => 'completed',
                    'completionProgress' => 10,
                    'lastAccessed' => now(),
                ]
            );

            $completedSections = Progress::where('userID', Auth::id())
                ->where('courseID', $id)
                ->where('progressName', 'like', 'SECTION_%')
                ->count();
        }

        $isCompletedAll = $completedSections >= $totalSections;

        return view('learner.startLearning', [
            'course' => $course,
            'sections' => $sections,
            'current' => $current,
            'currentTranslation' => $currentTranslation,
            'lecture' => $lecture,
            'currentIndex' => $currentIndex,
            'module' => $course->modules->firstWhere('moduleID', $current->moduleID ?? null),
            'completedSections' => $completedSections,
            'totalSections' => $totalSections,
            'isCompletedAll' => $isCompletedAll
        ]);
    }

    public function markComplete($lectID)
    {
        $userID = auth()->id();

        //save lecture completion
        DB::table('lectureprogress')->updateOrInsert(
            [
                'userID' => $userID,
                'lectID' => $lectID
            ],
            [
                'completed_at' => now()
            ]
        );

        //get module ID of this lecture
        $moduleID = DB::table('lecture')
            ->where('lectID', $lectID)
            ->value('moduleID');

        //get all lectures in this module
        $moduleLectures = DB::table('lecture')
            ->where('moduleID', $moduleID)
            ->pluck('lectID');

        //count completed lectures
        $completedLectures = DB::table('lectureprogress')
            ->where('userID', $userID)
            ->whereIn('lectID', $moduleLectures)
            ->count();

        $totalLectures = $moduleLectures->count();

        //check if module completed
        if ($completedLectures === $totalLectures) {
            DB::table('enrolmentcoursemodules')
                ->where('userID', $userID)
                ->where('moduleID', $moduleID)
                ->update([
                    'isCompleted' => 1,
                    'inProgress' => 0
                ]);
        }

        return response()->json(['status' => 'saved']);
    }

    //display questions
    public function showMCQS($id)
    {
        $module = Module::with('mcqs.answers')->findOrFail($id);
        $course = $module->course;
        return view('learner.module_question', compact('module', 'course'));
    }
    
    public function submitMCQS(Request $request, $id) 
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $module = Module::with('mcqs.answers')->findOrFail($id);

        $answers = $request->input('answers', []);
        $total = $module->mcqs->count();

        $score = 0;

        //calculate score first
        foreach ($module->mcqs as $question) {
            $selectedAnswer = $answers[$question->moduleQs_ID] ?? null;

            if ($selectedAnswer) {
                $correctAnswer = $question->answers->where('ansCorrect', 1)->first();

                if ($correctAnswer && $correctAnswer->ansID == $selectedAnswer) {
                    $score++;
                }
            }
        }

        //avoid division by zero
        $percentage = $total > 0 ? ($score / $total) * 100 : 0;

        $existing = DB::table('assessment_results')
            ->where('userID', Auth::id())
            ->where('moduleID', $module->moduleID)
            ->where('type', 'mcq')
            ->first();

        $attempts = $existing ? $existing->attempts + 1 : 1;
        //limit attempts
        if ($attempts > 3) {
            return redirect()->back()->with('error', 'You have reached the maximum number of attempts.');
        }
        
        //save into assessment_results
        DB::table('assessment_results')->updateOrInsert(
            [
                'userID' => Auth::id(),
                'moduleID' => $module->moduleID,
                'courseID' => $module->courseID,
                'type' => 'mcq'
            ],
            [
                'score' => $percentage,
                'status' => $percentage >= 80 ? 'pass' : 'fail',
                'attempts' => $attempts,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        //update progress with REAL score
        $this->updateProgress($module->courseID, 'MCQ' . $module->moduleID, $percentage);

        //pass to the view
        return redirect()->back()->with([
            'score' => $score,
            'total' => $total,
            'courseID' => $module->courseID,

            'goFeedback' => route('course.feedback', $module->courseID),
            'reviewUrl' => route('module.review', $module->moduleID)
        ]);
    }

    public function reviewMCQ($id)
    {
        $module = Module::with('mcqs.answers', 'course')->findOrFail($id);
        return view('learner.review_mcq', ['module' => $module,'course' => $module->course]);
    }

    //show feedback form
    public function courseFeedback($id)
    {
        $course = Course::with('modules')->findOrFail($id);
        return view('learner.course_feedback', compact('course'));
    }

    public function submitFeedback(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $request->validate(['clarity' => 'required','understanding' => 'required','rating' => 'required|integer|min:1|max:5']);
        
        DB::table('coursefeedback')->insert([
            'courseID' => $id,
            'clarity' => $request->clarity,
            'understanding' => $request->understanding,
            'favorite_module' => $request->favorite_module,
            'enjoyed' => $request->enjoyed,
            'suggestions' => $request->suggestions,
            'rating' => $request->rating,
            'userID' => Auth::id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('course.assessment', $id);
    }

    public function courseAssessment($id)
    {
        $userID = Auth::id();
        $course = Course::with('modules.lectures.sections', 'modules.mcqs')->findOrFail($id);

        // total sections
        $totalSections = 0;
        foreach ($course->modules as $module) {
            foreach ($module->lectures as $lecture) {
                $sectionCount = $lecture->sections->count();
                if ($sectionCount > 0) {
                    $totalSections += $sectionCount;
                }
            }
        }

        // completed sections
        $completedSections = Progress::where('courseID', $id)
            ->where('userID', $userID)
            ->where('progressName', 'like', 'SECTION_%')
            ->count();

        // total MCQ modules
        $totalMcqModules = $course->modules->filter(function ($module) {
            return $module->mcqs->count() > 0;
        })->count();

        // completed MCQs
        $mcqsCompleted = DB::table('assessment_results')
            ->where('courseID', $id)
            ->where('userID', $userID)
            ->where('type', 'mcq')
            ->count();

        $needsMCQ = $totalMcqModules > 0;

        //only check MCQ
        if ($needsMCQ && $mcqsCompleted < $totalMcqModules) {
            return redirect()->route('learn', ['id' => $id])
                ->with('error', 'Please complete all MCQs first.');
        }

        //redirect to real assessment page
        return redirect()
            ->route('assessment.show', $id)
            ->with('success', 'Assessment unlocked!');
    }
    
    public function submitFinalAssessment(Request $request, $courseID)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $score = $request->score;

        //get module safely
        $module = Module::where('courseID', $courseID)->first();

        if (!$module) {
            return back()->with('error', 'No module found for this course.');
        }

        $moduleID = $module->moduleID;

        DB::table('assessment_results')->updateOrInsert(
            [
                'userID' => Auth::id(),
                'courseID' => $courseID,
                'type' => 'final'
            ],
            [
                'moduleID' => $moduleID,
                'score' => $score,
                'status' => $score >= 80 ? 'pass' : 'fail',
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        $this->updateProgress($courseID, 'FINAL_ASSESSMENT', $score);

        return redirect()->route('course.progress', $courseID);
    }
    
    //update progress auto when a user finishes MCQ or assessment given
    public function updateProgress($courseID, $activity, $percentage = 100)
    {
        if (!Auth::check()) {
            return;
        }

        Progress::updateOrCreate(
            [
                'userID' => Auth::id(),
                'courseID' => $courseID,
                'progressName' => $activity
            ],
            [
                'progressStatus' => 'completed',
                'completionProgress' => $percentage,
                'lastAccessed' => now(),
            ]
        );
    }

    //show overall percentage
    public function showAllProgress($courseID)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $course = Course::findOrFail($courseID);

        $progress = Progress::where('userID', Auth::id())
            ->where('courseID', $courseID)
            ->get();

        // total progress (still from progress table)
        $totalProgress = round($progress->avg('completionProgress') ?? 0, 1);

        // get MCQ grades from assessment_results
        $grades = DB::table('assessment_results')->where('userID', Auth::id())->where('courseID', $courseID)->get()->map(function ($item) use ($course) {
            //if moduleID exists → it's MCQ
            if ($item->type === 'mcq') {
                $name = 'MCQ ' . $item->moduleID;
            } 
            //else, final assessment
            else {
                $name = 'Course Assessment of ' . $course->courseName;
            }

            return [
                'name' => $name,
                'score' => round($item->score, 2) . '%',
                'status' => ucfirst($item->status),
            ];
        });

        $isCompletedAll = DB::table('assessment_results')
            ->where('userID', Auth::id())
            ->where('courseID', $courseID)
            ->where('type', 'final')
            ->where('status', 'pass')
            ->exists();

        return view('learner.course_progress', compact(
            'course',
            'progress',
            'totalProgress',
            'grades',
            'isCompletedAll'
        ));
    }

    public function generateCertificate($courseID)
    {
        $user = auth()->user();
        $course = Course::findOrFail($courseID);
        $pdf = Pdf::loadView('learner.certificate', [
            'user' => $user,
            'course' => $course
        ])->setPaper('A4', 'portrait');
        $studentName = str_replace(' ', '_', $user->userName);
        $courseName = str_replace(' ', '_', $course->courseName);
        $fileName = $studentName . '_' . $courseName . '_Certificate.pdf';
        return $pdf->download($fileName);
    }

    public function completeLecture($lectID)
    {
        LectureProgress::updateOrCreate(
            [
                'userID' => Auth::id(),
                'lectID' => $lectID
            ],
            [
                'completed_at' => now()
            ]
        );
        return back()->with('success', 'Lecture marked as completed');
    }

    public function completeAndNext(Request $request)
    {
        $userID = Auth::id();

        //mark lecture complete
        LectureProgress::updateOrCreate(
            [
                'userID' => $userID,
                'lectID' => $request->lectID
            ],
            [
                'completed_at' => now()
            ]
        );

        //update module completion
        $lecture = Lecture::find($request->lectID);
        $moduleID = $lecture->moduleID;

        $totalLectures = Lecture::where('moduleID', $moduleID)->count();

        $completedLectures = LectureProgress::where('userID', $userID)
            ->whereIn('lectID', Lecture::where('moduleID', $moduleID)->pluck('lectID'))
            ->count();

        if ($completedLectures == $totalLectures) {
            Enrollment::where('userID', $userID)
                ->where('moduleID', $moduleID)
                ->update([
                    'isCompleted' => 1,
                    'inProgress' => 0
                ]);
        }

        //redirect to next section
        return redirect()->route('learn', ['id' => $request->courseID,'sectionId' => $request->nextSectionID]);
    }
    
    //only registered users can view
    public function leaderboard()
    {
        $learners = DB::table('userprogress')
            ->join('users', 'userprogress.userID', '=', 'users.userID')
            ->select(
                'users.userName as name',
                DB::raw('COUNT(DISTINCT userprogress.courseID) as completed_courses')
            )
            ->where('userprogress.progressStatus', 'completed')
            ->groupBy('userprogress.userID', 'users.userName')
            ->orderByDesc('completed_courses')
            ->get();

        return view('learner.leaderboards', compact('learners'));
    }
}