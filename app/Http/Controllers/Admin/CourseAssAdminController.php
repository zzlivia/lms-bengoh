<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseAssessment;
use App\Models\AssessmentQuestion;
use App\Models\AssessmentMcqOption;
use Illuminate\Http\Request;

class CourseAssAdminController extends Controller
{
    public function storeAssessment(Request $request)
    {
        //validation
        $request->validate([
        'courseID' => 'required|exists:course,courseID',
        'title' => 'required|string|max:255',
        'desc' => 'nullable|string',
        'questions' => 'required|array|min:1',

        'questions.*.question' => 'required|string',
        'questions.*.type' => 'required|in:MCQ,SHORT_ANSWER,LONG_ANSWER',

        // only for MCQ
        'questions.*.options' => 'required_if:questions.*.type,MCQ|array',
        'questions.*.options.*.text' => 'required|string',
        'questions.*.options.*.is_correct' => 'required|boolean',]);
    
        //logics
        $assessment = CourseAssessment::create([
            'courseID' => $request->courseID,
            'courseAssTitle' => $request->title,
            'courseAssDesc' => $request->desc]);

        foreach ($request->questions as $q) {
            $question = AssessmentQuestion::create([
                'courseAssID' => $assessment->courseAssID,
                'courseAssQs' => $q['question'],
                'courseAssType' => $q['type']
            ]);

            //only MCQ
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

    public function saveAssessment(Request $request)
    {
        $request->validate([
            'courseID' => 'required|exists:course,courseID',
            'title' => 'required|string|max:255',
            'desc' => 'nullable|string',
        ]);

        $assessment = CourseAssessment::create([
            'courseID' => $request->courseID,
            'courseAssTitle' => $request->title,
            'courseAssDesc' => $request->desc
        ]);

        //redirect to add questions page
        return redirect()->route('admin.assessment.addQs', $assessment->courseAssID)->with('success', 'Assessment created! Now add questions.');
    }

    //display questions page
    public function addQuestionsPage($id)
    {
        $assessment = CourseAssessment::findOrFail($id);
        return view('admin.addAssessmentQuestions', compact('assessment'));
    }

    public function storeQuestions(Request $request)
    {
        foreach ($request->questions as $q) {

            $question = AssessmentQuestion::create([
                'courseAssID' => $request->courseAssID,
                'courseAssQs' => $q['text'],
                'courseAssType' => $q['type']
            ]);

            if ($q['type'] === 'MCQ') {
                foreach ($q['options'] as $index => $opt) {
                    AssessmentMcqOption::create([
                        'assQsID' => $question->assQsID,
                        'optionText' => $opt,
                        'is_correct' => ($index == $q['correct'])
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Questions saved successfully!');
    }

    public function manageAss(Request $request)
    {
        $query = CourseAssessment::with('course');

        // filter by course
        if ($request->courseID) {
            $query->where('courseID', $request->courseID);
        }

        // sorting
        $assessments = $query->orderBy('created_at', 'desc')->get();

        $courses = \App\Models\Course::all();

        return view('admin.viewAssessments', compact('assessments', 'courses'));
    }

    public function deleteAss($id)
    {
        $assessment = CourseAssessment::findOrFail($id);
        $assessment->delete();
        return redirect()->back()->with('success', 'Assessment deleted successfully');
    }

    public function editAss($id)
    {
        $assessment = CourseAssessment::findOrFail($id);
        $courses = \App\Models\Course::all();

        return view('admin.editAss', compact('assessment', 'courses'));
    }

    public function updateAss(Request $request, $id)
    {
        $request->validate([
            'courseID' => 'required|exists:course,courseID',
            'title' => 'required|string|max:255',
            'desc' => 'nullable|string',
        ]);

        $assessment = CourseAssessment::findOrFail($id);

        $assessment->update([
            'courseID' => $request->courseID,
            'courseAssTitle' => $request->title,
            'courseAssDesc' => $request->desc,
        ]);

        return redirect()
            ->route('admin.assessment.manageCourseAss')
            ->with('success', 'Assessment updated successfully');
    }
    
    public function showQuestions($id)
    {
        $assessment = CourseAssessment::with('questions.options')
            ->findOrFail($id);

        return view('admin.viewQuestions', compact('assessment'));
    }

    public function addQuestions($id)
    {
        $assessment = CourseAssessment::with('questions.options')
            ->findOrFail($id);

        return view('admin.addAssessmentQuestions', compact('assessment'));
    }

    public function editQuestions($id)
    {
        $assessment = CourseAssessment::with('questions.options')
            ->findOrFail($id);

        return view('admin.editQuestions', compact('assessment'));
    }

    public function deleteQuestion($id)
    {
        $question = AssessmentQuestion::findOrFail($id);

        // delete options first
        AssessmentMcqOption::where('assQsID', $id)->delete();

        $question->delete();

        return back()->with('success', 'Question deleted successfully!');
    }
}