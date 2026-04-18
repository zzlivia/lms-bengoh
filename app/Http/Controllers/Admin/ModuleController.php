<?php

//create modules, save modules
//view courses, modules, lectures
//edit and delete modules, lecture
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; //base controller
//import models
use App\Models\Course;
use App\Models\Module;
use App\Models\Lecture;
use App\Models\Mcqs;
use App\Models\LectureSection;
use Illuminate\Http\Request; //handles form requests
use Illuminate\Support\Facades\DB;

class ModuleController extends Controller
{
    public function createModule() //create module page
    {
        //get all courses from db to be used for dropdown selection
        $courses = Course::all(); 
        return view('admin.modules.create_module', compact('courses')); //send data to view
    }

    public function storeNewModule(Request $request)//store new module
    {   
        //validate input of user
        $request->validate([
            'moduleName' => 'required|string|max:255',
            'courseID' => 'required|exists:course,courseID'
        ]);
        //create new module in db
        Module::create([ 
            'moduleName' => $request->moduleName,
            'courseID' => $request->courseID
        ]);
        //redirect back
        return redirect()->route('admin.course.module')->with('success', 'Module added successfully!');
    }

    public function courseModule() //show overall courses, modules, lectures
    {
        $courses = Course::all(); //get all courses
        $modules = Module::with('course')->get(); //get modules that related with respective course
        $lectures = Lecture::with('module')->get(); //get lectures that related with respective module
        //send to view
        return view('admin.add_course_module', compact('courses','modules','lectures'));
    }

    public function editModule($id) //edit module page
    {
        $module = Module::where('moduleID', $id)->firstOrFail(); //find by moduleID, if not found then show 404
        $courses = Course::all(); //get all courses 

        return view('admin.editModule', compact('module','courses')); //send to edit page
    }

    public function deleteModule($id) //delete module
    {
        Module::where('moduleID', $id)->delete(); //delete module by its ID
        return redirect()->back()->with('success','Module deleted successfully'); //return back to previous page
    }

    // store main lecture information
    public function storeLecture(Request $request)
    {   //validate 
        $request->validate([
            'moduleID' => 'required|exists:module,moduleID',
            'lectName' => 'required',
            'lect_duration' => 'required'
        ]);
        $module = Module::findOrFail($request->moduleID);
        $module->lectures()->create([
            'lectName' => $request->lectName,
            'lect_duration' => $request->lect_duration,
        ]);
        //redirect back
        return redirect()->route('admin.course.module')->with('success','Lecture saved!');
    }

    public function editLecture($id)//edit lecture 
    {
        $lecture = Lecture::where('lectID', $id)->firstOrFail(); //find lecture with lectID
        $modules = Module::all(); //get all modules

        return view('admin.editLecture', compact('lecture','modules')); //send back data
    }

    public function deleteLecture($id) //delete lecture
    {
        Lecture::where('lectID', $id)->delete(); //delete lecture through lectID
        return redirect()->back()->with('success','Lecture deleted successfully'); //redirect back
    }

    //for admin's view
    public function showAddCourse()
    {
        $courses = Course::all();
        $modules = Module::with('course')->get();
        $lectures = Lecture::with('module')->get();
        $sections = LectureSection::with('lecture')->orderBy('section_order')->get();

        return view('admin.add_course_module', compact('courses','modules','lectures','sections'));
    }

    //handling courses
    public function lectureStore(Request $request)
    {
        // 1. Validation
        $request->validate([
            'lectID' => 'required|unique:lectures,lectID',
            'moduleID' => 'required|exists:modules,moduleID',
            'lectName' => 'required|string|max:255',
            'lect_duration' => 'required|integer',
        ]);

        // 2. Creation
        Lecture::create([
            'lectID'        => $request->lectID,
            'moduleID'      => $request->moduleID,
            'lectName'      => $request->lectName,
            'lect_duration' => $request->lect_duration,
        ]);

        return redirect()->back()->with('success', 'Lecture added successfully!');
    }

    public function viewModule($id)
    {
        $module = Module::with('mcqs.answers')->where('moduleID', $id)->firstOrFail();
        return view('learner.module_questions', compact('module'));
    }

    public function storeMCQ(Request $request)
    {
        foreach ($request->questions as $q) {

            $questionID = \DB::table('mcqs')->insertGetId([
                'moduleID' => $request->moduleID,
                'moduleQs' => $q['text'],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            foreach ($q['answers'] as $index => $answer) {
                \DB::table('moduleans')->insert([
                    'moduleQs_ID' => $questionID,
                    'ansID_text' => $answer,
                    'ansCorrect' => ($index == $q['correct']) ? 1 : 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }

        return back()->with('success', 'All MCQs added successfully!');
    }

    public function previewMCQ($moduleID)
    {
        $questions = Mcqs::where('moduleID', $moduleID)
            ->orderBy('moduleQs_ID')
            ->get();

        return view('admin.preview', compact('questions'));
    }

    public function editMCQ($moduleID)
    {
        $module = Module::with('mcqs.answers')
                    ->where('moduleID', $moduleID)
                    ->firstOrFail();

        return view('admin.edit_mcq', compact('mcq'));
    }

    public function toggleMCQ($moduleID)
    {
        $module = Module::where('moduleID', $moduleID)->firstOrFail();

        // toggle (1 → 0, 0 → 1)
        $module->mcq_enabled = $module->mcq_enabled ? 0 : 1;
        $module->save();

        return back()->with('success', 'MCQ status updated!');
    }
}