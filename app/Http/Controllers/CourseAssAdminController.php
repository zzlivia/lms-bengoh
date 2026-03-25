<?php

namespace App\Http\Controllers;

use App\Models\CourseAssessment;
use App\Models\AssessmentQuestion;
use App\Models\AssessmentMcqOption;
use Illuminate\Http\Request;

class CourseAssAdminController extends Controller
{
    public function storeAssessment(Request $request)
    {
        $assessment = CourseAssessment::create([
            'courseID' => $request->courseID,
            'courseAssTitle' => $request->title,
            'courseAssDesc' => $request->desc
        ]);

        foreach ($request->questions as $q) {
            $question = AssessmentQuestion::create([
                'courseAssID' => $assessment->courseAssID,
                'courseAssQs' => $q['question'],
                'courseAssType' => $q['type']
            ]);

            // Only MCQ
            if ($q['type'] === 'MCQ') {
                foreach ($q['options'] as $opt) {
                    AssessmentMcqOption::create([
                        'assQsID' => $question->assQsID,
                        'optionText' => $opt['text'],
                        'is_correct' => $opt['is_correct']
                    ]);
                }
            }
        }

        return response()->json([
            'message' => 'Assessment created successfully'
        ]);
    }

    public function displayAssessment($courseID)
    {
        return CourseAssessment::where('courseID', $courseID)
            ->with('questions.options')
            ->get();
    }
}