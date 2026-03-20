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
use Illuminate\Http\Request; //handles form requests

class ModuleController extends Controller
{
    public function create() //create module page
    {
        //get all courses from db to be used for dropdown selection
        $courses = Course::all(); 
        return view('admin.modules.create_module', compact('courses')); //send data to view
    }

    public function store(Request $request)//store new module
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
}