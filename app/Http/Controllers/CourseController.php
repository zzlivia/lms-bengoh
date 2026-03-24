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
    public function startLearning(Request $request, $id, $sectionId = null)
    {
        $course = Course::with(['modules.lectures.sections'])->findOrFail($id);
        //collect all sections
        $sections = collect();
        foreach ($course->modules as $module) {
            foreach ($module->lectures as $lecture) {
                foreach ($lecture->sections as $section) {
                    $sections->push($section);
                }
            }
        }
        //sort by display_order
        $sections = $sections->sortBy('section_order')->values();
        //collection session
        $totalSections = $sections->count();
        if ($sections->isEmpty()) { //if there is no content in the module
            return redirect()->route('courses.showCourse', $course->courseID)
                ->with('error', 'This module has no learning materials yet.');
        }
        $completedSections = 0;
        $isCompletedAll = $completedSections >= $totalSections;
        //get current section
        if ($sectionId) {
            $currentIndex = $sections->search(fn($s) => (int)$s->sectionID === (int)$sectionId);
            if ($currentIndex === false) {
                $currentIndex = 0;
            }

            $current = $sections[$currentIndex];

            //to track per section
            if (Auth::check()) {
                Progress::updateOrCreate(
                    [
                        'userID' => Auth::id(),
                        'courseID' => $id,
                        'progressName' => 'SECTION_' . $current->sectionID
                    ],
                    [
                        'progressStatus' => 'completed',
                        'completionProgress' => 10
                    ]
                );
            }
            

            if (Auth::check()) {
                $completedSections = Progress::where('userID', Auth::id())
                    ->where('courseID', $id)
                    ->where('progressName', 'like', 'SECTION_%')
                    ->count();
            }
            
        } else {
            $current = $sections->first();
            $currentIndex = 0;
        }
        return view('learner.startlearning', [
            'course' => $course,
            'sections' => $sections,
            'current' => $current,
            'currentIndex' => $currentIndex,
            'module' => $course->modules->firstWhere('moduleID', $current->moduleID ?? null), //fetch module with current section
            'completedSections' => $completedSections,
            'totalSections' => $totalSections,
            'isCompletedAll' => $isCompletedAll
        ]);
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
        $module = Module::with('mcqs.answers')->findOrFail($id);

        $answers = $request->input('answers', []);
        $total = $module->mcqs->count();
        $answered = count($answers);

        // block if not skip
        if ($answered < $total && $request->input('force_submit') != '1') {
            return redirect()->back()
                ->withInput()
                ->with('warning', "You answered $answered out of $total questions. Please complete all or skip.");
        }

        // calculate score
        $score = 0;

        foreach ($module->mcqs as $question) {
            $selectedAnswer = $answers[$question->moduleQs_ID] ?? null;

            if ($selectedAnswer) {
                $correctAnswer = $question->answers->where('ansCorrect', 1)->first();

                if ($correctAnswer && $correctAnswer->ansID == $selectedAnswer) {
                    $score++;
                }
            }
        }

        return redirect()->route('mcq.module', ['id' => $module->moduleID])
            ->withInput($request->all())
            ->with([
                'score' => $score,
                'total' => $total,
                'completed' => true,
                'goFeedback' => route('course.feedback', ['id' => $module->courseID]),
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
        $request->validate([
            'clarity' => 'required',
            'understanding' => 'required',
            'rating' => 'required|integer|min:1|max:5'
        ]);

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
        $course = Course::findOrFail($id);
        return view('learner.courseAssessment', compact('course'));
    }

    //update progress auto when a user finishes MCQ or assessment given
    public function updateProgress($courseID, $activity)
    {
        $progressMap = ['MCQ1' => 20,'MCQ2' => 40,'MCQ3' => 60,'MCQ4' => 80,'ASSESSMENT' => 100];
        $percentage = $progressMap[$activity] ?? 0;
        Progress::updateOrCreate(
            ['userID' => Auth::id(),'courseID' => $courseID,'progressName' => $activity],
            ['progressStatus' => 'completed','completionProgress' => $percentage]
        );
    }

    //show overall percentage
    public function showAllProgress($courseID)
    {
        $course = Course::findOrFail($courseID);

        $progress = Progress::where('userID', Auth::id())
                    ->where('courseID', $courseID)
                    ->get();

        //total progress
        $totalProgress = $progress->avg('completionProgress') ?? 0;

        //mcqs grades only
        $grades = $progress
            ->filter(function ($item) {
                return str_contains($item->progressName, 'MCQ');
            })
            ->map(function ($item) {
                return [
                    'name' => $item->progressName,
                    'score' => $item->completionProgress . '%'
                ];
            });

        return view('learner.course_progress', compact(
            'course',
            'progress',
            'totalProgress',
            'grades'
        ));
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
        //count completed courses per user
        $learners = DB::table('userprogress')
            ->select('userID', DB::raw('COUNT(DISTINCT courseID) as completed_courses'))
            ->where('progressStatus', 'completed')
            ->groupBy('userID')
            ->orderByDesc('completed_courses')
            ->get();

        //join with users table to get names
        $learners = $learners->map(function ($item) {
            $user = Users::find($item->userID);
            $item->name = $user->name ?? 'Unknown';
            return $item;
        });

        return view('leaderboards', compact('learners'));
    }
}