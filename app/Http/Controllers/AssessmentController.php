<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    //show assessment to learners
    public function showAssessment($id)
    {
        $course = Course::with([
            'modules.lectures.sections',
            'modules.mcqs'
        ])->findOrFail($id);

        $assessment = DB::table('course_assessments')
            ->where('courseID', $id)
            ->first();

        if (!$assessment) {
            return back()->with('error', 'No assessment found.');
        }

        $questions = DB::table('assessment_qs')
            ->where('courseAssID', $assessment->courseAssID)
            ->get();

        foreach ($questions as $q) {
            $q->options = DB::table('assessment_mcq_options')
                ->where('assQsID', $q->assQsID)
                ->get();
        }

        return view('learner.courseAssessment', compact('assessment', 'questions', 'course'));
    }

    //learner submit answers processes
    public function submitAssessment(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // prevent multiple submissions
        $existingAttempt = DB::table('courseassattempts')
            ->where('userID', Auth::user()->userID)
            ->where('courseAssID', $request->courseAssID)
            ->first();

        if ($existingAttempt) {
            return redirect()->route('course.progress', [
                'id' => $request->courseID
            ])->with('info', 'You already completed this assessment.');
        }

        // get questions
        $questions = DB::table('assessment_qs')
            ->where('courseAssID', $request->courseAssID)
            ->get();

        $answers = $request->input('answers', []);

        // OPTIONAL: allow empty but prevent totally empty submission
        if (empty($answers)) {
            return back()->with('error', 'Please answer at least one question.');
        }

        // initialize
        $score = 0;
        $total = 0;

        // ✅ CREATE attempt ONCE
        $attemptID = DB::table('courseassattempts')->insertGetId([
            'userID' => Auth::user()->userID,
            'courseAssID' => $request->courseAssID,
            'submitted_at' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // ✅ SINGLE LOOP ONLY
        foreach ($questions as $q) {

            $answer = $answers[$q->assQsID] ?? null;

            // skip empty answers
            if (!$answer || trim($answer) === '') {
                continue;
            }

            if ($q->courseAssType == 'MCQ') {

                $option = DB::table('assessment_mcq_options')
                    ->where('id', $answer)
                    ->first();

                if ($option) {
                    $total++;

                    if ($option->is_correct) {
                        $score++;
                    }

                    DB::table('courseassanswers')->insert([
                        'attemptID' => $attemptID,
                        'assQsID' => $q->assQsID,
                        'selected_option_id' => $option->id,
                        'is_correct' => $option->is_correct,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }

            } else {

                DB::table('courseassanswers')->insert([
                    'attemptID' => $attemptID,
                    'assQsID' => $q->assQsID,
                    'answer_text' => trim($answer),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }

        // save score
        DB::table('courseassattempts')
            ->where('attemptID', $attemptID)
            ->update([
                'score' => $score
            ]);

        // save result
        DB::table('assessment_results')->updateOrInsert(
            [
                'userID' => Auth::user()->userID,
                'courseID' => $request->courseID
            ],
            [
                'score' => $score,
                'status' => 'completed',
                'updated_at' => now(),
                'created_at' => now()
            ]
        );

        // ✅ REDIRECT WORKS HERE
        return redirect()->route('course.progress', [
            'id' => $request->courseID
        ])->with([
            'assessment_completed' => true,
            'score' => $score,
            'total' => $total
        ]);
    }

    //allow admin to view the results of course assessment
    public function viewResults($id)
    {
        $attempts = DB::table('course_ass_attempts')
            ->join('users', 'course_ass_attempts.userID', '=', 'users.userID')
            ->where('course_ass_attempts.courseAssID', $id)
            ->select('course_ass_attempts.*', 'users.userName')
            ->get();

        foreach ($attempts as $attempt) {
            $attempt->answers = DB::table('courseassanswers')
                ->where('attemptID', $attempt->attemptID)
                ->get();
        }

        return view('admin.assessment_results', compact('attempts'));
    }
}