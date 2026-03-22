<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use App\Models\Progress;
//use App\Models\Lecture;
//use App\Models\LectureSection;
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
    public function startLearning($id, Request $request, $sectionId = null)
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
            $currentIndex = $sections->search(fn($s) => $s->sectionID == $sectionId);

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
            'module' => $course->modules->first(),
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

        $answers = $request->answers; 
        $score = 0;
        $total = $module->mcqs->count();

        // calculate score
        foreach ($module->mcqs as $question) {
            $selectedAnswer = $answers[$question->moduleQs_ID] ?? null;

            if ($selectedAnswer) {
                $correctAnswer = $question->answers->where('ansCorrect', 1)->first();

                if ($correctAnswer && $correctAnswer->ansID == $selectedAnswer) {
                    $score++;
                }
            }
        }

        // find next module
        $nextModule = Module::where('courseID', $module->courseID)
            ->where('moduleID', '>', $module->moduleID)
            ->orderBy('moduleID')
            ->first();

        //dd($nextModule->lectures()->count()); //module considered empty if there is no module
        // skip modules with NO lectures
        while ($nextModule && $nextModule->lectures()->count() == 0) {
            $nextModule = Module::where('courseID', $module->courseID)
                ->where('moduleID', '>', $nextModule->moduleID)
                ->orderBy('moduleID')
                ->first();
        }

        //if next module exists → go there
        if ($nextModule) {
            return redirect()->route('module.start', $nextModule->moduleID)
                ->with('success', "You scored $score / $total. Moving to next module.");
        }

        //if no module available
        return redirect()->route('course.view', $module->courseID)
            ->with('warning', "You scored $score / $total. Lectures are not yet available.");
    }

    //show feedback form
    public function courseFeedback($id)
    {
        $course = Course::with(['modules.lectures.mcqs'])->findOrFail($id);
        return view('learner.course_feedback', compact('course'));
    }

    public function submitFeedback(Request $request)
    {
        return redirect()->back()->with('success','Thank you for your feedback!');
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
        $progress = Progress::where('userID', Auth::id())
                    ->where('courseID', $courseID)
                    ->get(); //return all progress records
        return view('learner.course_progress', compact('progress'));
    }
    
    //only registered users can view
    public function leaderboard()
    {
        $learners = DB::table('userprogress')
            ->join('users', 'userprogress.userID', '=', 'users.id')
            ->select(
                'users.name',
                DB::raw('COUNT(DISTINCT userprogress.courseID) as completed_courses')
            )
            ->where('userprogress.progressStatus', 'completed')
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('completed_courses')
            ->get();

        return view('courses.leaderboards', compact('learners'));
    }
}