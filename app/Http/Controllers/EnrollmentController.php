<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EnrolmentController extends Controller
{
    public function enrol($courseID)
    {
        $user = Auth::user(); //identify current signed in user
        $course = Course::with('modules')->findOrFail($courseID); //find the requested course from db
        //check if the user has enrolled
        $exists = DB::table('enrolmentcoursemodules') //to prevent user frm double enrolling
            ->where('userID', $user->userID)
            ->where('courseID', $courseID)
            ->exists();
        if ($exists) {
            //return redirect()->route('course.learn', $courseID)->with('info', 'You are already enrolled in this course.');
        }
        //create enrolment records for each module
        foreach ($course->modules as $module) {
            DB::table('enrolmentcoursemodules')->insert([
                'userID'      => $user->userID, //who
                'courseID'    => $courseID,     //what
                'moduleID'    => $module->moduleID, //what
                'isCompleted' => false, //status
                'inProgress'  => false, //status
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
        //return redirect()->route('course.learn', $courseID)->with('success', 'Successfully enrolled! Enjoy your learning.');
    }
}
