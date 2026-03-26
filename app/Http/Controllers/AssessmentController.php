<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    //show assessment to learners
    public function showAssessment($id)
    {
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

        return view('learner.courseAssessment', compact('assessment', 'questions'));
    }

    //learner submit answers processes
    public function submitAssessment(Request $request)
    {
        //prevent multiple submissions
        $existingAttempt = DB::table('course_ass_attempts')
            ->where('userID', Auth::id())
            ->where('courseAssID', $request->courseAssID)
            ->first();

        if ($existingAttempt) {
            return back()->with('error', 'You have already submitted this assessment.');
        }

        //initialize
        $score = 0;
        $total = 0;

        $attemptID = DB::table('course_ass_attempts')->insertGetId([
            'userID' => Auth::id(),
            'courseAssID' => $request->courseAssID,
            'submitted_at' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        foreach ($request->answers as $questionID => $answer) {

            $question = DB::table('assessment_qs')
                ->where('assQsID', $questionID)
                ->first();

            if (!$question) continue;

            if ($question->courseAssType == 'MCQ') {

                $option = DB::table('assessment_mcq_options')
                    ->where('id', $answer)
                    ->first();

                if ($option) {

                    //count total MCQ
                    $total++;

                    //check for correctness
                    if ($option->is_correct) {
                        $score++;
                    }

                    DB::table('course_ass_answers')->insert([
                        'attemptID' => $attemptID,
                        'assQsID' => $questionID,
                        'selected_option_id' => $option->id,
                        'is_correct' => $option->is_correct,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }

            } else {

                DB::table('course_ass_answers')->insert([
                    'attemptID' => $attemptID,
                    'assQsID' => $questionID,
                    'answer_text' => $answer,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }

        //save the score
        DB::table('course_ass_attempts')
            ->where('attemptID', $attemptID)
            ->update([
                'score' => $score
            ]);

        //store latest result summary
        DB::table('assessment_results')->updateOrInsert( //first attempt will be inserted first but next attempt will be updated
            [
                'userID' => Auth::id(),
                'courseID' => $request->courseID
            ],
            [
                'score' => $score,
                'status' => 'completed',
                'updated_at' => now(),
                'created_at' => now()
            ]
        );

        //redirect to progress page
        return redirect()->route('course.progress', $request->courseID)
            ->with([
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
            $attempt->answers = DB::table('course_ass_answers')
                ->where('attemptID', $attempt->attemptID)
                ->get();
        }

        return view('admin.assessment_results', compact('attempts'));
    }
}